<?php

namespace App\Dto\Product;

class ProductDto
{
    private $code;
    private $name;
    private $description;
    private $stock;
    private $price;
    private $sale_price;
    private $cost;

    public function __construct(
        ?string $code,
        ?string $name,
        ?string $description,
        ?int $stock,
        ?float $price,
        ?float $sale_price,
        ?float $cost
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->stock = $stock;
        $this->price = $price;
        $this->sale_price = $sale_price;
        $this->cost = $cost;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSalePrice(): float
    {
        return $this->sale_price;
    }

    public function getCost(): float
    {
        return $this->cost;
    }
}
