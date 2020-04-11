<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\ProductAttributeTranslation as BaseProductAttributeTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_attribute_translation")
 */
class ProductAttributeTranslation extends BaseProductAttributeTranslation
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
     * @ORM\ManyToOne(targetEntity="ProductAttribute", inversedBy="translations")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translatable;
}
