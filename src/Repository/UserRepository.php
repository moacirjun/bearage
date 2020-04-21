<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function search()
    {
        return $this->searchAsQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    public function searchAsQueryBuilder()
    {
        return $this->createQueryBuilder('user');
    }
}
