<?php

namespace App\Repository\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractBaseRepository extends ServiceEntityRepository
{
    public function save(object $object): object
    {
        $this->_em->persist($object);
        $this->_em->flush();

        return $object;
    }
}
