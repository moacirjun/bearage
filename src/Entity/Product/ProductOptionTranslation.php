<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductOptionTranslation as BaseProductOptionTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_option_translation")
 */
class ProductOptionTranslation extends BaseProductOptionTranslation
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
     * @ORM\ManyToOne(targetEntity="ProductOption", inversedBy="translations")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translatable;
}
