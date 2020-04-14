<?php

namespace App\Entity\Product;

use Sylius\Component\Inventory\Model\StockableInterface;
use Sylius\Component\Product\Model\ProductVariantInterface as SyliusProductVariantInterface;

interface ProductVariantInterface extends SyliusProductVariantInterface, StockableInterface
{
    public function setCost(float $cost): void;

    public function setPrice(float $price): void;

    public function setSalePrice(float $salePrice): void;

    public function getCost(): ?float;

    public function getPrice(): ?float;

    public function getSalePrice(): ?float;
}
