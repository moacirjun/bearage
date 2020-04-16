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
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\Order", inversedBy="adjustments")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $order;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\OrderItem", inversedBy="adjustments")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $orderItem;

    /**
     * @inheritDoc
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\OrderItemUnit", inversedBy="adjustments")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $orderItemUnit;

    /**
     * @inheritDoc
     *
     * @ORM\Column()
     */
    protected $type;

    /**
     * @inheritDoc
     *
     * @ORM\Column(nullable=true)
     */
    protected $label;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $amount = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="boolean", name="is_neutral")
     */
    protected $neutral = false;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="boolean", name="is_locked")
     */
    protected $locked = false;

    /**
     * @inheritDoc
     *
     * @ORM\Column(nullable=true)
     */
    protected $originCode;

    /**
     * @inheritDoc
     * @ORM\Column(type="datetime")
    */
    protected $createdAt;

    /**
     * @inheritDoc
     * @ORM\Column(type="datetime", nullable=true)
    */
    protected $updatedAt;
}
