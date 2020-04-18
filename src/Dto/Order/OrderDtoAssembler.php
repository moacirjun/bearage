<?php

namespace App\Dto\Order;

use App\Entity\Order\Order;
use App\Entity\Order\OrderInterface;

class OrderDtoAssembler
{
    public function writeDto(OrderInterface $order)
    {
        $newDto = new OrderDto(
            $order->getId(),
            $order->getNumber(),
            $order->getState(),
            $order->getNotes(),
            -$order->getAdjustmentsTotalRecursively('discount'),
            $order->getAdjustmentsTotalRecursively('tax'),
            $order->getTotal()
        );

        foreach ($order->getItems() as $orderItem) {
            $newDto->addItem(OrderItemDtoAssembler::writeDto($orderItem));
        }

        return $newDto;
    }
}
