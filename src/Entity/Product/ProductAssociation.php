<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductAssociation as BaseProductAssociation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_association")
 */
class ProductAssociation extends BaseProductAssociation
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
     * @ORM\OneToOne(targetEntity="ProductAssociationType")
     * @ORM\JoinColumn(name="association_type_id")
     */
    protected $type;

    /**
     * @inheritDoc 
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="associations")
     * @ORM\JoinColumn(name="product_name")
     */
    protected $owner;

    /**
     * @inheritDoc 
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(
     *      name="sylius_product_association_product",
     *      joinColumns={@ORM\JoinColumn(name="product_association_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     * )
     */
    protected $associatedProducts;
    
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
}
