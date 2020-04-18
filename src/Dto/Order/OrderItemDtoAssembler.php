<?php

namespace App\Dto\Order;

use App\Entity\Order\OrderItemInterface;

class OrderItemDtoAssembler
{
    public function writeDto(OrderItemInterface $orderItem)
    {
        return new OrderItemDto(
            $orderItem->getVariant()->getCode(),
            $orderItem->getUnits()->count(),
            -$orderItem->getAdjustmentsTotalRecursively('discount'),
            $orderItem->getAdjustmentsTotalRecursively('tax'),
            $orderItem->getUnitPrice(),
            $orderItem->getTotal()
        );
    }
}
