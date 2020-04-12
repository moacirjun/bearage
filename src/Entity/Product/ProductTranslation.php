<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductTranslation as BaseProductTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_translation")
 */
class ProductTranslation extends BaseProductTranslation
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
    protected $slug;

    /**
     * @inheritDoc
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @inheritDoc
     * @ORM\Column(nullable=true)
     */
    protected $metaKeywords;

    /**
     * @inheritDoc
     * @ORM\Column(nullable=true)
     */
    protected $metaDescription;

    /**
     * @inheritDoc
     * @ORM\Column()
     */
    protected $locale;

    /**
     * @inheritDoc
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="translations")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translatable;
}
