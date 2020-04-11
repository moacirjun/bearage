<?php

namespace App\Entity\Order;

use Sylius\Component\Order\Model\Order as SyliusOrder;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order")
 */
class Order extends SyliusOrder
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
     * @ORM\Column()
     */
    protected $number;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="datetime", name="checkout_completed_at")
     */
    protected $checkoutCompletedAt;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="text")
     */
    protected $notes;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer", name="items_total")
     */
    protected $itemsTotal = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer", name="adjustments_total")
     */
    protected $adjustmentsTotal = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $total = 0;

    /**
     * @inheritDoc
     *
     * @ORM\Column()
     */
    protected $state = OrderInterface::STATE_CART;

    /**
     * @inheritDoc
     *
     * @ORM\OneToMany(targetEntity="Adjustment", mappedBy="order")
     */
    protected $adjustments;

    /**
     * @inheritDoc
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Order\OrderItem", mappedBy="order")
     */
    protected $items;
}
