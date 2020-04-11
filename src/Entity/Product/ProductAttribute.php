<?php

namespace App\Entity\Product;

use Sylius\Component\Attribute\Model\AttributeTranslationInterface;
use Sylius\Component\Product\Model\ProductAttribute as BaseProductAttribute;
use Sylius\Component\Attribute\AttributeType\TextAttributeType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_attribute")
 */
class ProductAttribute extends BaseProductAttribute
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
     * @ORM\Column()
     */
    protected $type = TextAttributeType::TYPE;

    /**
     * @inheritDoc
     * @ORM\Column(type="array")
     */
    protected $configuration = [];

    /**
     * @inheritDoc
     * @ORM\Column()
     */
    protected $storageType;

    /**
     * @inheritDoc
     * @ORM\Column(type="integer")
     */
    protected $position;
        
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
     * @ORM\OneToMany(targetEntity="ProductAttributeTranslation", mappedBy="translatable")
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translations;

    protected function createTranslation(): AttributeTranslationInterface
    {
        return new ProductAttributeTranslation();
    }
}
