<?php

namespace App\DataFixtures;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Order\OrderItemUnit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Product\Model\ProductInterface;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        /** @var ProductInterface[] $products */
        $products = [
            $this->getReference('product-name1'),
            $this->getReference('product-name2'),
            $this->getReference('product-name3'),
        ];

        foreach ($products as $product) {
            $orderItem = new OrderItem();
            $orderItemUnit = new OrderItemUnit($orderItem);

            $productVariant = $product->getVariants()->first();
            $orderItem->setVariant($productVariant);

            $newOrder = new Order();
            $newOrder->addItem($orderItem);

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
}
