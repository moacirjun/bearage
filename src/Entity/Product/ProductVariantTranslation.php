<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductVariantTranslation as BaseProductVariantTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant_translation")
 */
class ProductVariantTranslation extends BaseProductVariantTranslation
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
    protected $name;

    /**
     * @inheritDoc
     * @ORM\Column()
     */
    protected $locale;

    /**
     * @inheritDoc 
     * @ORM\ManyToOne(targetEntity="ProductVariant", inversedBy="translations")
     */
    protected $translatable;
}
