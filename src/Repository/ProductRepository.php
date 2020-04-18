<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function search()
    {
        return $this->searchAsQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function searchAsQueryBuilder()
    {
        return $this->createQueryBuilder('products');
    }
}
