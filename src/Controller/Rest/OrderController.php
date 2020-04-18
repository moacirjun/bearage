<?php

namespace App\Controller\Rest;

use App\Dto\Order\OrderDtoAssembler;
use App\Entity\Order\Adjustment;
use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Order\OrderItemUnit;
use App\Entity\Product\ProductVariant;
use App\Entity\Product\ProductVariantInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\View\View;
use Sylius\Component\Order\Model\AdjustableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrderController extends Controller
{
    /**
     * @Route("", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $newOrder = new Order();
        $newOrder->setExternalId($request->get('number'));
        $newOrder->setNumber(uniqid("BES", true));
        $newOrder->setNotes($request->get('notes'));
        $newOrder->setCheckoutCompletedAt(new \DateTime());

        foreach($request->get('items') as $item) {
            $variantRepository = $em->getRepository(ProductVariant::class);
            $productVariant = $variantRepository->findOneBy(['code' => $item['id']]);

            if (!$productVariant instanceof ProductVariantInterface) {
                $errorMessage = sprintf('Validation error: Product with id [%s] not found', $item['id']);
                return View::create(['message' => $errorMessage], Response::HTTP_BAD_REQUEST);
            }

            $orderItem = new OrderItem();

            $quantity = $item['quantity'] ?? 1;
            $quantity = max($quantity, 1);

            for ($count = 0; $count < $quantity; $count++) {
                $orderItemUnit = new OrderItemUnit($orderItem);
            }

            //TODO: STOCK MANAGEMENT -> Make a service to manage stock
            $productVariant->setOnHand($productVariant->getOnHand() - $quantity);
            $em->persist($productVariant);

            $orderItem->setVariant($productVariant);
            $orderItem->setUnitPrice($item['unit']);

            $this->addAdjustment($orderItem, $item['discount'], 'discount');
            $this->addAdjustment($orderItem, $item['tax'], 'tax');

            $newOrder->addItem($orderItem);
        }

        $this->addAdjustment($newOrder, $request->get('order_discount'), 'discount');
        $this->addAdjustment($newOrder, $request->get('order_tax'), 'tax');

        $newOrder->recalculateAdjustmentsTotal();
        $newOrder->recalculateItemsTotal();

        $em->persist($newOrder);
        $em->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    public function addAdjustment(AdjustableInterface &$adjustable, $discount, $type = 'discount')
    {
        if (!$discount) {
            return;
        }

        $adjustmentValue = $type === 'discount' ? $discount * -1 : $discount;

        $adjustment = new Adjustment();
        $adjustment->setAmount($adjustmentValue);
        $adjustment->setType($type);

        $adjustable->addAdjustment($adjustment);
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function listOrders(EntityManagerInterface $em)
    {
        $orders = $em->getRepository(Order::class)->findAll();
        $ordersDto = [];

        foreach ($orders as $order) {
            $ordersDto[] = OrderDtoAssembler::writeDto($order);
        }

        return View::create($ordersDto, Response::HTTP_OK);
    }

    /**
     * @Route("/{number}", methods={"GET"})
     */
    public function listSingleOrder(Request $request, EntityManagerInterface $em)
    {
        $orderNumber = $request->attributes->get('number');
        $repository = $em->getRepository(Order::class);

        $order = $repository->findOneBy(['number' => $orderNumber]);

        if (!$order instanceof Order) {
            throw new EntityNotFoundException(sprintf('Order with number[%s] not found', $orderNumber));
        }

        $orderDto = OrderDtoAssembler::writeDto($order);

        return View::create($orderDto, Response::HTTP_OK);
    }

    /**
     * @Route("/{number}/cancel", methods={"PUT"})
     */
    public function cancelOrder(Request $request, EntityManagerInterface $em)
    {
        $orderNumber = $request->attributes->get('number');
        $repository = $em->getRepository(Order::class);

        $order = $repository->findOneBy(['number' => $orderNumber]);

        if (!$order instanceof Order) {
            throw new EntityNotFoundException(sprintf('Order with number[%s] not found', $orderNumber));
        }

        $order->setState(Order::STATE_CANCELLED);

        $em->persist($order);
        $em->flush();

        return View::create(null, Response::HTTP_OK);
    }
}
