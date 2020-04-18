<?php

namespace App\Dto\Order;

class OrderItemDto
{
    /** @var string|null */
    private $id;
    /** @var int|null */
    private $quantity;
    /** @var float|null */
    private $discount;
    /** @var float|null */
    private $tax;
    /** @var float|null */
    private $unit;
    /** @var float|null */
    private $total;

    public function __construct(
        ?string $id,
        ?int $quantity,
        ?float $discount,
        ?float $tax,
        ?float $unit,
        ?float $total
    ) {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->discount = $discount;
        $this->tax = $tax;
        $this->unit = $unit;
        $this->total = $total;
    }

    /**
     * Get the value of id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Get the value of discount
     */
    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * Get the value of tax
     */
    public function getTax(): ?float
    {
        return $this->tax;
    }

    /**
     * Set the value of tax
     *
     * @return  self
     */
    public function setTax($tax): void
    {
        $this->tax = $tax;
    }

    /**
     * Get the value of unit
     */
    public function getUnit(): ?float
    {
        return $this->unit;
    }

    /**
     * Set the value of unit
     *
     * @return  self
     */
    public function setUnit($unit): void
    {
        $this->unit = $unit;
    }

    /**
     * Get the value of total
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }
}
