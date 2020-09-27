<?php

namespace App\Repository\Doctrine;

use App\Entity\FormResponse;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormResponse[]    findAll()
 * @method FormResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormResponseRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormResponse::class);
    }
}
