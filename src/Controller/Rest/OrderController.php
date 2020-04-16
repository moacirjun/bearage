<?php

namespace App\Controller\Rest;

use App\Entity\Order\Adjustment;
use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Order\OrderItemUnit;
use App\Entity\Product\ProductVariant;
use App\Entity\Product\ProductVariantInterface;
use Doctrine\ORM\EntityManagerInterface;
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
        $newOrder->setNumber($request->get('number'));
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

            $quatity = $item['quatity'] ?? 1;
            $quatity = max($quatity, 1);

            for ($count = 0; $count < $quatity; $count++) {
                $orderItemUnit = new OrderItemUnit($orderItem);
            }

            $orderItem->setVariant($productVariant);
            $orderItem->setUnitPrice($productVariant->getSalePrice());


            $this->addAdjustment($orderItem, $item['discount'], 'discount');
            $this->addAdjustment($orderItem, $item['tax'], 'tax');

            if ($orderItem->getAdjustments()->count() > 0) {
                $em->persist($orderItem->getAdjustments());
            }

            $orderItem->recalculateUnitsTotal();

            $newOrder->addItem($orderItem);
        }

        $this->addAdjustment($newOrder, $request->get('order_discount'), 'discount');
        $this->addAdjustment($newOrder, $request->get('order_tax'), 'tax');

        $newOrder->recalculateAdjustmentsTotal();
        $newOrder->recalculateItemsTotal();

        if ($newOrder->getAdjustments()->count() > 0) {
            dump($newOrder->getAdjustments());
            $em->persist($newOrder->getAdjustments());
        }

        $em->persist($newOrder);
        $em->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    public function addAdjustment(AdjustableInterface &$adjustable, $discount, $type = 'discount')
    {
        if (!$discount) {
            return;
        }

        $adjustment = new Adjustment();
        $adjustment->setAmount($discount);
        $adjustment->setType($type);

        $adjustable->addAdjustment($adjustment);

        dump($adjustable, $adjustment);
    }
}
