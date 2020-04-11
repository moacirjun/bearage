<?php

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\ProductAssociationType as BaseProductAssociationType;
use Sylius\Component\Product\Model\ProductAssociationTypeTranslationInterface;
use Sylius\Component\Product\Model\ProductAssociationTypeTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_association_type")
 */
class ProductAssociationType extends BaseProductAssociationType
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
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @inheritDoc 
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    /**
     * @inheritDoc 
     * @ORM\OneToMany(targetEntity="ProductAssociationTypeTranslation", mappedBy="translatable")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translations;

    protected function createTranslation(): ProductAssociationTypeTranslationInterface
    {
        return new ProductAssociationTypeTranslation();
    }
}
