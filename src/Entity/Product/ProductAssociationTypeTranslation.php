<?php

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductAssociationTypeTranslation as BaseProductAssociationTypeTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_association_type_translation")
 */
class ProductAssociationTypeTranslation extends BaseProductAssociationTypeTranslation
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
     * @ORM\ManyToOne(targetEntity="ProductAssociationType", inversedBy="translations")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translatable;
}
