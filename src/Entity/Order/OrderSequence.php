<?php

namespace App\Entity\Order;

use Sylius\Component\Order\Model\OrderSequence as SyliusOrderSequence;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order_sequence")
 */
class OrderSequence extends SyliusOrderSequence
{
    /**
     * @inheritDoc
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @inheritDoc
     *
     * @ORM\Column(type="integer")
     */
    protected $index = 0;
}
