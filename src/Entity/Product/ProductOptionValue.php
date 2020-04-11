<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\ProductOptionValue as BaseProductOptionValue;
use Sylius\Component\Product\Model\ProductOptionValueTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_option_value")
 */
class ProductOptionValue extends BaseProductOptionValue
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
     * @ORM\ManyToOne(targetEntity="ProductOption", inversedBy="values")
     */
    protected $option;

    /**
     * @inheritDoc 
     * @ORM\OneToMany(targetEntity="ProductOptionValueTranslation", mappedBy="translatable");
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translations;

    protected function createTranslation(): ProductOptionValueTranslationInterface
    {
        return new ProductOptionValueTranslation();
    }
}
