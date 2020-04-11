<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Sylius\Component\Product\Model\ProductAttributeValue as BaseProductAttributeValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_attribute_value")
 */
class ProductAttributeValue extends BaseProductAttributeValue
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="attributes")
     * @ORM\JoinColumn(name="product_id")
     */
    protected $subject;

    /**
     * @inheritDoc
     * @ORM\ManyToOne(targetEntity="ProductAttribute")
     * @ORM\JoinColumn(name="attribute_id")
     */
    protected $attribute;

    /**
     * @inheritDoc
     * @ORM\Column()
     */
    protected $localeCode;

    /**
     * @inheritDoc
     * @ORM\Column(type="text", name="text_value")
     */
    private $text;

    /**
     * @inheritDoc
     * @ORM\Column(type="boolean", name="boolean_value")
     */
    private $boolean;

    /**
     * @inheritDoc
     * @ORM\Column(type="integer", name="integer_value")
     */
    private $integer;

    /**
     * @inheritDoc
     * @ORM\Column(type="float", name="float_value")
     */
    private $float;

    /**
     * @inheritDoc
     * @ORM\Column(type="datetime", name="datetime_value")
     */
    private $datetime;

    /**
     * @inheritDoc
     * @ORM\Column(type="date", name="date_value")
     */
    private $date;

    /**
     * @inheritDoc
     * @ORM\Column(type="json_array", name="json_value")
     */
    private $json;
}
