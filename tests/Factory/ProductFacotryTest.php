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
        $product = $factory->make('code', 'name', 'slug', 'description');

        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('code', $product->getCode());
        $this->assertEquals('name', $product->getName());
        $this->assertEquals('slug', $product->getSlug());
        $this->assertEquals('description', $product->getDescription());
    }
}
