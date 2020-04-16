<?php

namespace App\Entity\Order;

use Sylius\Component\Order\Model\OrderInterface as SyliusOrderInterface;

interface OrderInterface extends SyliusOrderInterface
{
    public function getExternalId(): ?string;

    public function setExternalId($externalId): void;
}
