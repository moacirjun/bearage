<?php

namespace App\Entity\Order;

use Sylius\Component\Inventory\Model\InventoryUnitInterface;
use Sylius\Component\Order\Model\OrderItemUnitInterface as SyliusOrderItemUnitInterface;

interface OrderItemUnitInterface extends SyliusOrderItemUnitInterface, InventoryUnitInterface
{

}
