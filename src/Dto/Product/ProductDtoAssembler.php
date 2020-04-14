<?php

namespace App\Dto\Product;

use App\Factory\Product\ProductFactory;
use Sylius\Component\Product\Model\ProductInterface;

class ProductDtoAssembler
{
    public static function createProduct(ProductDto $dto) : ProductInterface
    {
        return (new ProductFactory)->make(
            $dto->getName(),
            $dto->getDescription(),
            $dto->getStock(),
            $dto->getPrice(),
            $dto->getSalePrice(),
            $dto->getCost()
        );
    }

    public static function updateProduct(ProductInterface &$product, ProductDto $dto)
    {
        $product->setCode($dto->getCode());
        $product->setName($dto->getName());
        $product->setDescription($dto->getDescription());
    }

    public static function writeDto(ProductInterface $product) : ProductDto
    {
        $variant = $product->getVariants()->first();

        return new ProductDto(
            $product->getCode(),
            $product->getName(),
            $product->getDescription(),
            $variant ? $variant->getOnHand() : null,
            $variant ? $variant->getPrice() : null,
            $variant ? $variant->getSalePrice() : null,
            $variant ? $variant->getCost() : null
        );
    }
}
