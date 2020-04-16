<?php

namespace App\Entity\Order;

use Sylius\Component\Order\Model\OrderItem as SyliusOrderItem;
use Sylius\Component\Product\Model\ProductInterface;
use App\Entity\Product\ProductVariantInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order_item")
 */
class OrderItem extends SyliusOrderItem implements OrderItemInterface
{
    /**
     * @inheritDoc
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\Order", inversedBy="items")
     */
    protected $order;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $quantity = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $unitPrice = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $total = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $immutable = false;

    /**
     * @inheritDoc
     *@ORM\OneToMany(targetEntity="OrderItemUnit", mappedBy="orderItem", cascade={"persist", "remove"})
     */
    protected $units;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $unitsTotal = 0;

    /**
     * @inheritDoc
     *
     * @ORM\OneToMany(targetEntity="Adjustment", mappedBy="orderItem")
     */
    protected $adjustments;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $adjustmentsTotal = 0;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\ProductVariant")
     */
    private $variant;

    /**
     * @return null|ProductVariantInterface
     */
    public function getVariant(): ?ProductVariantInterface
    {
        return $this->variant;
    }

    /**
     * @param ProductVariantInterface $variant
     */
    public function setVariant(?ProductVariantInterface $variant): void
    {
        $this->variant = $variant;
    }

    /**
     * @inheritDoc
     */
    public function getProduct(): ?ProductInterface
    {
        return $this->variant->getProduct();
    }

    /**
     * @inheritDoc
     */
    public function getProductName(): ?string
    {
        if (!empty($this->productName)) {
            return  $this->productName;
        }

        if (null === $this->variant) {
            return '';
        }

        if (null === $this->variant->getProduct()) {
            return '';
        }

        $this->productName = $this->variant->getProduct()->getName();
        return $this->productName;
    }

    /**
     * @inheritDoc
     */
    public function getVariantName(): ?string
    {
        if (!empty($this->variantName)) {
            return  $this->variantName;
        }

        if (null === $this->variant) {
            return '';
        }

        $this->variantName = $this->variant->getName();
        return $this->variantName;
    }

    /**
     * @inheritDoc
     */
    public function setProductName(?string $name): void
    {
        $this->productName = $name;
    }

    /**
     * @inheritDoc
     */
    public function setVariantName(?string $name): void
    {
        $this->variantName = $name;
    }
}
