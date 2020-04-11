<?php

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductOption as BaseProductOption;
use Sylius\Component\Product\Model\ProductOptionTranslationInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_option")
 */
class ProductOption extends BaseProductOption
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
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @inheritDoc 
     * @ORM\OneToMany(targetEntity="ProductOptionValue", mappedBy="option");
     */
    protected $values;

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
     * @ORM\OneToMany(targetEntity="ProductOptionTranslation", mappedBy="translatable");
     * @ORM\JoinColumn(name="translatable_id")
     */
    protected $translations;

    protected function createTranslation(): ProductOptionTranslationInterface
    {
        return new ProductOptionTranslation();
    }
}
