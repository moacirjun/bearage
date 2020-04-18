<?php

namespace App\Dto\Order;

use Doctrine\Common\Collections\ArrayCollection;

class OrderDto
{
    /** @var int|null */
    private $id;

    /** @var string|null */
    private $number;

    /** @var string|null */
    private $state;

    /** @var string|null */
    private $notes;

    /** @var float|null */
    private $order_discount;

    /** @var float|null */
    private $order_tax;

    /** @var float|null */
    private $grand_total;

    /** @var ArrayCollection|null */
    private $items;

    public function __construct(
        ?int $id,
        ?string $number,
        ?string $state,
        ?string $notes,
        ?float $order_discount,
        ?float $order_tax,
        ?float $grand_total,
        ?ArrayCollection $items = null
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->state = $state;
        $this->notes = $notes;
        $this->order_discount = $order_discount;
        $this->order_tax = $order_tax;
        $this->grand_total = $grand_total;
        $this->items = $items ?? new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber($number): void
    {
        $this->number = $number;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState($state): void
    {
        $this->state = $state;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes($notes): void
    {
        $this->notes = $notes;
    }

    public function getOrderDiscount(): ?float
    {
        return $this->order_discount;
    }

    public function setOrderDiscount($order_discount): void
    {
        $this->order_discount = $order_discount;
    }

    public function getOrderTax(): ?float
    {
        return $this->order_tax;
    }

    public function setOrderTax($order_tax): void
    {
        $this->order_tax = $order_tax;
    }

    public function getGrandTotal()
    {
        return $this->grand_total;
    }

    public function setGrandTotal($grand_total): void
    {
        $this->grand_total = $grand_total;
    }

    public function getItems(): ?ArrayCollection
    {
        return $this->items;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function addItem($item): void
    {
        $this->items->add($item);
    }
}
