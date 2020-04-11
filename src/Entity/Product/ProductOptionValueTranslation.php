<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\ProductOptionValueTranslation as BaseProductOptionValueTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_option_value_translation")
 */
class ProductOptionValueTranslation extends BaseProductOptionValueTranslation
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
    protected $value;

    /**
     * @inheritDoc
     * @ORM\Column()
     */
    protected $locale;

    /**
     * @inheritDoc 
     * @ORM\ManyToOne(targetEntity="ProductOptionValue", inversedBy="translations")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translatable;
}
