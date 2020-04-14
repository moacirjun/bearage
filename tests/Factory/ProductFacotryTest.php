<?php

namespace App\Tests\Factory;

use App\Entity\Product\Product;
use App\Resources\Locale;
use App\Factory\Product\ProductFactory;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Product\Model\ProductInterface;

class ProductFactoryTest extends TestCase
{
    public function testMake()
    {
        $factory = new ProductFactory();
        $factory->setlocale(Locale::DEFAULT_LOCALE_CODE);

        /** @var Product */
        $product = $factory->make('name', 'description', 200, 198, 20);
        $variant = $product->getVariants()->first();

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('name', $product->getName());
        $this->assertEquals('description', $product->getDescription());
        $this->assertEquals(20, $variant->getCost());
        $this->assertEquals(200, $variant->getPrice());
        $this->assertEquals(198, $variant->getSalePrice());
    }
}
