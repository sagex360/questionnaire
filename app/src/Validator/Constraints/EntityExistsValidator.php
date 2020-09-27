<?php

namespace App\Validator\Constraints;

use App\Utils\ObjectUtils;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EntityExistsValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EntityExists) {
            throw new UnexpectedTypeException($constraint, EntityExists::class);
        }

        if (ObjectUtils::isEntity($value)) {
            $value = ObjectUtils::getIdFromEntity($value);
        }

        if ($this->isValid($value, $constraint)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setCode(EntityExists::ENTITY_NOT_FOUND)
            ->addViolation();
    }

    private function isValid($value, EntityExists $constraint): bool
    {
        if (null === $value) {
            return true;
        }

        if (!Uuid::isValid($value)) {
            return false;
        }

        $qb = $this->entityManager->createQueryBuilder()
            ->select('entity')
            ->from($constraint->class, 'entity')
            ->setMaxResults(1)
        ;

        foreach (array_merge(['id' => $value], $constraint->params) as $param => $value) {
            $qb
                ->andWhere("entity.$param = :$param")
                ->setParameter($param, $value)
            ;
        }

        $callback = $constraint->callback;
        if ($callback && is_callable($callback)) {
            $callback($qb);
        }

        return null !== $qb->getQuery()->getOneOrNullResult();
    }
}
