<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function search()
    {
        return $this->searchAsQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function searchAsQueryBuilder()
    {
        return $this->createQueryBuilder('orders');
    }
}
