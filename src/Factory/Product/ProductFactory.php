<?php

namespace App\Factory\Product;

use App\Entity\Product\Product;
use App\Resources\Locale;
use Sylius\Component\Product\Model\ProductInterface;

class ProductFactory
{
    protected $locale;

    public function make(string $code, string $name = '', string $slug = '', string $desciption = '') : ProductInterface
    {
        $product = new Product();
        $product->setCode($code);
        $product->setCurrentLocale($this->getLocale());

        if ($name !== '') {
            $product->setName($name);
        }

        if ($desciption !== '') {
            $product->setDescription($desciption);
        }

        if ($slug !== '') {
            $product->setSlug($slug);
        }

        return $product;
    }

    public function setlocale(string $locale)
    {
        $this->locale = $locale;
    }

    private function getLocale()
    {
        return $this->locale ?: Locale::DEFAULT_LOCALE_CODE;
    }
}
