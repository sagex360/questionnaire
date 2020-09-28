<?php

namespace App\Repository\Doctrine;

use App\Entity\Form;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Form|null find($id, $lockMode = null, $lockVersion = null)
 * @method Form|null findOneBy(array $criteria, array $orderBy = null)
 * @method Form[]    findAll()
 * @method Form[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormRepository extends AbstractBaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Form::class);
    }

    /**
     * @return array
     */
    public function getFormRatio()
    {
        $result = $this->_em->createQueryBuilder()
            ->select(sprintf('(%s)', $this->createFormCountQueryBuilder('f1', true)->getDQL()) . ' as withResponse')
            ->addSelect(sprintf('(%s)', $this->createFormCountQueryBuilder('f2', false)->getDQL()) . ' as withNoResponse')
            ->from(Form::class, 'f')
            ->getQuery()
            ->setMaxResults(1)
            ->getScalarResult()
        ;

        return $result[0] ?? [];
    }

    /**
     * @return array
     */
    public function getResponseCountPerForm(): array
    {
        return $this->_em->createQueryBuilder()
            ->select('f.id, f.name')
            ->from(Form::class, 'f')
            ->addSelect('COUNT(response.id) as responseCount')
            ->leftJoin('f.responses', 'response')
            ->groupBy('f.id')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    private function createFormCountQueryBuilder(string $alias, bool $withResponses): QueryBuilder
    {
        $qb = $this->_em->createQueryBuilder()
            ->select("COUNT($alias.id)")
            ->from(Form::class, $alias);

        if ($withResponses) {
            $qb->where("$alias.responses IS NOT EMPTY");
        } else {
            $qb->where("$alias.responses IS EMPTY");
        }

        return $qb;
    }
}
