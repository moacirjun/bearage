<?php

namespace App\DataFixtures;

use App\Factory\Product\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dataProvider = [
            [
                'code' => 'code1',
                'name' => 'name1',
                'description' => 'description1',
                'stock' => 10,
                'price' => 13,
                'sale_price' => 12,
                'cost' => 10,
            ], [
                'code' => 'code2',
                'name' => 'name2',
                'description' => 'description2',
                'stock' => 20,
                'price' => 23,
                'sale_price' => 22,
                'cost' => 20,
            ], [
                'code' => 'code3',
                'name' => 'name3',
                'description' => 'description3',
                'stock' => 30,
                'price' => 33,
                'sale_price' => 32,
                'cost' => 30,
            ]
        ];

        $productFactory = new ProductFactory();

        foreach ($dataProvider as $productArray) {
            $product = $productFactory->make(
                $productArray['name'],
                $productArray['description'],
                $productArray['stock'],
                $productArray['price'],
                $productArray['sale_price'],
                $productArray['cost'],
                $productArray['code'],
            );

            $manager->persist($product);

            $this->addReference('product-' . $productArray['name'], $product);
            $this->addReference('product-variant-' . $productArray['name'], $product->getVariants()->first());
        }

        $manager->flush();
    }
}
