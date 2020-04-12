<?php

namespace App\Dto\Product;

class ProductDto
{
    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /** @var string */
    private $slug;

    /** @var string */
    private $description;

    public function __construct(string $code, string $name, string $slug, string $description)
    {
        $this->code = $code;
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
