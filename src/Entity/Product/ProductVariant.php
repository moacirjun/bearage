<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\ProductVariant as BaseProductVariant;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
class ProductVariant extends BaseProductVariant implements ProductVariantInterface
{
    /**
     * @inheritDoc
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @inheritDoc
     * @ORM\Column()
     */
    protected $code;

    /**
     * @inheritDoc
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="variants")
     */
    protected $product;

    /**
     * @var Collection|ProductOptionValueInterface[]
     *
     * @psalm-var Collection<array-key, ProductOptionValueInterface>
     */
    protected $optionValues;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $onHold;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $onHand;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    private $salePrice;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="is_tracked")
     */
    private $isTracked;

    /**
     * @inheritDoc
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @inheritDoc
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;

    /**
     * @inheritDoc
     * @ORM\OneToMany(targetEntity="ProductVariantTranslation", mappedBy="translatable")
     */
    protected $translations;

    protected function createTranslation(): ProductVariantTranslationInterface
    {
        return new ProductVariantTranslation();
    }

    public function getInventoryName(): ?string
    {
        return $this->getProduct()->getName() . '::' . $this->getCode();
    }

    public function isInStock(): bool
    {
        return 0 < $this->onHold;
    }

    public function getOnHold(): ?int
    {
        return $this->onHold;
    }

    public function setOnHold(?int $onHold): void
    {
        $this->onHold = max($onHold, 0);
    }

    public function getOnHand(): ?int
    {
        return $this->onHand;
    }

    public function setOnHand(?int $onHand): void
    {
        $this->onHand = max($onHand, 0);
    }

    public function isTracked(): bool
    {
        return $this->isTracked;
    }

    public function setTracked(bool $tracked): void
    {
        $this->isTracked = $tracked;
    }

    public function setCost(float $cost): void
    {
        $this->cost = $cost;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setSalePrice(float $salePrice): void
    {
        $this->salePrice = $salePrice;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }
}
