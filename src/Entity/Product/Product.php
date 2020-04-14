<?php

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\Product as BaseProduct;
use App\Entity\Product\ProductTranslation;
use App\Resources\Locale;
use Sylius\Component\Product\Model\ProductTranslationInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct
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
     * @ORM\Column()
     */
    protected $code;

    /**
     * @inheritDoc
     * @ORM\OneToMany(targetEntity="ProductAttributeValue", mappedBy="subject")
     * @ORM\JoinColumn(name="subject_id")
     */
    protected $attributes;

    /**
     * @inheritDoc
     * @ORM\OneToMany(targetEntity="ProductVariant", mappedBy="product")
     */
    protected $variants;

    /**
     * @inheritDoc
     * @ORM\ManyToMany(targetEntity="ProductOption")
     * @ORM\JoinTable(
     *      name="sylius_product_options",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_option_id", referencedColumnName="id")}
     * )
     */
    protected $options;

    /**
     * @inheritDoc
     * @ORM\OneToMany(targetEntity="ProductAssociation", mappedBy="owner")
     */
    protected $associations;

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
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @inheritDoc
     * @ORM\OneToMany(
     *      targetEntity="ProductTranslation",
     *      mappedBy="translatable",
     *      cascade={"persist", "remove"},
     *      fetch="EAGER",
     *      indexBy="locale"
     * )
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translations;

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }

    public function getTranslation(?string $locale = null): TranslationInterface
    {
        return parent::getTranslation($locale ?? Locale::DEFAULT_LOCALE_CODE);
    }
}
