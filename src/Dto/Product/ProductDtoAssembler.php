<?php

namespace App\Dto\Product;

use App\Factory\Product\ProductFactory;
use Sylius\Component\Product\Model\ProductInterface;

class ProductDtoAssembler
{
    public static function createProduct(ProductDto $dto) : ProductInterface
    {
        return (new ProductFactory)->make(
            $dto->getCode() ?? '',
            $dto->getName(),
            $dto->getSlug(),
            $dto->getDescription()
        );
    }

    public static function updateProduct(ProductInterface &$product, ProductDto $dto)
    {
        $product->setCode($dto->getCode());
        $product->setName($dto->getName());
        $product->setSlug($dto->getSlug());
        $product->setDescription($dto->getDescription());
    }

    public static function writeDto(ProductInterface $product) : ProductDto
    {
        return new ProductDto(
            $product->getCode() ?? '',
            $product->getName() ?? '',
            $product->getSlug() ?? '',
            $product->getDescription() ?? ''
        );
    }
}
