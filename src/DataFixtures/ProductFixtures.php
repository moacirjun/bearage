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
                'slug' => 'slug1',
                'description' => 'description1',
            ], [
                'code' => 'code2',
                'name' => 'name2',
                'slug' => 'slug2',
                'description' => 'description2',
            ], [
                'code' => 'code3',
                'name' => 'name3',
                'slug' => 'slug3',
                'description' => 'description3',
            ]
        ];

        $productFactory = new ProductFactory();

        foreach ($dataProvider as $productArray) {
            $product = $productFactory->make(
                $productArray['code'],
                $productArray['name'],
                $productArray['slug'],
                $productArray['description']
            );

            $manager->persist($product);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
