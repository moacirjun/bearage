<?php

namespace App\Entity\Order;

use Sylius\Component\Order\Model\OrderItemInterface as SyliusOrderInterface;
use Sylius\Component\Product\Model\ProductInterface;
use App\Entity\Product\ProductVariantInterface;

interface OrderItemInterface extends SyliusOrderInterface
{
    /**
     * @return null|ProductVariantInterface
     */
    public function getVariant(): ?ProductVariantInterface;

    /**
     * @param ProductVariantInterface $variant
     */
    public function setVariant(?ProductVariantInterface $variant): void;

    /**
     * @return ProductInterface|null
     */
    public function getProduct(): ?ProductInterface;

    /**
     * @return string|null
     */
    public function getProductName(): ?string;

    /**
     * @return string|null
     */
    public function getVariantName(): ?string;

    /**
     * @param string|null $name
     */
    public function setProductName(?string $name): void;

    /**
     * @param string|null $name
     */
    public function setVariantName(?string $name): void;
}
