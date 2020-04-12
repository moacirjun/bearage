<?php

namespace App\Entity\Order;

use Sylius\Component\Order\Model\Adjustment as SyliusAdjustment;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_adjustment")
 */
class Adjustment extends SyliusAdjustment
{
    /**
     * @inheritDoc
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="adjustments")
     */
    protected $order;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="OrderItem", inversedBy="adjustments")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $orderItem;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="OrderItemUnit", inversedBy="adjustments")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $orderItemUnit;

    /**
     * @inheritDoc
     *
     * @ORM\column()
     */
    protected $type;

    /**
     * @inheritDoc
     *
     * @ORM\column()
     */
    protected $label;

    /**
     * @inheritDoc
     *
     * @ORM\column(type="integer")
     */
    protected $amount = 0;

    /**
     * @inheritDoc
     *
     * @ORM\column(type="boolean", name="is_neutral")
     */
    protected $neutral = false;

    /**
     * @inheritDoc
     *
     * @ORM\column(type="boolean", name="is_locked")
     */
    protected $locked = false;

    /**
     * @inheritDoc
     *
     * @ORM\column()
     */
    protected $originCode;
}
