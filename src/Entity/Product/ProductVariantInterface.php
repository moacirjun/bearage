<?php

namespace App\Entity\Product;

use Sylius\Component\Inventory\Model\StockableInterface;
use Sylius\Component\Product\Model\ProductVariantInterface as SyliusProductVariantInterface;

interface ProductVariantInterface extends SyliusProductVariantInterface, StockableInterface
{
}
