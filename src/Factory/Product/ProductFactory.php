<?php

namespace App\Factory\Product;

use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Resources\Locale;
use Sylius\Component\Product\Model\ProductInterface;
use Symfony\Component\VarDumper\Caster\UuidCaster;

class ProductFactory
{
    protected $locale;

    public function make(
        string $name,
        string $desciption,
        int $stock,
        float $price,
        ?float $salePrice = null,
        ?float $cost = null
    ) : ProductInterface {
        $product = new Product();
        $product->setCode(uniqid("BES", true));
        $product->setCurrentLocale($this->getLocale());

        $product->setName($name);
        $product->setSlug(md5($product->getCode()));
        $product->setDescription($desciption);

        $productVariant = new ProductVariant();
        $productVariant->setOnHand($stock);
        $productVariant->setPrice($price);
        $productVariant->setCode($product->getCode() . '-1');
        $productVariant->setPosition(1);
        $productVariant->setOnHold(0);
        $productVariant->setTracked(false);

        if (null !== $salePrice) {
            $productVariant->setSalePrice($salePrice);
        }

        if (null !== $cost) {
            $productVariant->setCost($cost);
        }

        $product->addVariant($productVariant);

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
