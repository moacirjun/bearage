<?php

namespace App\DataFixtures;

use App\Entity\Order\Adjustment;
use App\Entity\Order\Order;
use App\Entity\Order\OrderInterface;
use App\Entity\Order\OrderItem;
use App\Entity\Order\OrderItemUnit;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Product\Model\ProductVariantInterface;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        /** @var ProductVariantInterface[] $productVariants */
        $newOrderDatas = [
            [
                'number' => 'BES1000',
                'notes' => 'no notes 1',
                'discount' => 4,
                'tax' => 0,
                'total' => 20,
            ], [
                'number' => 'BES1001',
                'notes' => 'no notes 2',
                'discount' => 12,
                'tax' => 0,
                'total' => 34,
            ], [
                'number' => 'BES1002',
                'notes' => 'no notes 3',
                'discount' => 0,
                'tax' => 12,
                'total' => 98,
            ]
        ];
        $productVariants = [
            $this->getReference('product-variant-name1'),
            $this->getReference('product-variant-name2'),
            $this->getReference('product-variant-name3'),
        ];

        foreach ($newOrderDatas as $key => $orderData) {
            $orderItem = new OrderItem();
            $orderItemUnit = new OrderItemUnit($orderItem);

            $orderItem->setVariant($productVariants[$key]);

            $newOrder = new Order();
            $newOrder->addItem($orderItem);
            $newOrder->setNumber($orderData['number']);
            $newOrder->setNotes($orderData['notes']);
            $newOrder->setCheckoutCompletedAt(new DateTime());

            // $this->addDiscount($newOrder, $orderData['discount']);
            // $this->addTaxes($newOrder, $orderData['tax']);

            $newOrder->recalculateAdjustmentsTotal();
            $newOrder->recalculateItemsTotal();

            // $em->persist($newOrder->getAdjustments());
            $em->persist($newOrder);
        }

        $em->flush();
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }

    private function addDiscount(OrderInterface &$order, $discount)
    {
        if (!$discount) {
            return;
        }

        $adjustment = new Adjustment();
        $adjustment->setAmount($discount);
        $adjustment->setType('discount');

        $adjustment->setAdjustable($order);
    }

    private function addTaxes(OrderInterface &$order, $tax)
    {
        $adjustment = new Adjustment();
        $adjustment->setAmount($tax);
        $adjustment->setType('tax');

        $adjustment->setAdjustable($order);
    }
}
