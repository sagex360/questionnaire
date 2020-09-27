<?php

namespace App\Repository\Doctrine;

use App\Entity\FormQuestion;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormQuestion[]    findAll()
 * @method FormQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormQuestionRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormQuestion::class);
    }

    /**
     * @param string[] $ids
     * @return FormQuestion[]
     */
    public function findByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids]);
    }
}
