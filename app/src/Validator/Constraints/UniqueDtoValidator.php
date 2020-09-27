<?php

namespace App\Validator\Constraints;

use App\Utils\ArrayUtils;
use App\Mapper\DtoToEntityMapper;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueDtoValidator extends UniqueEntityValidator
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);

        $this->registry = $registry;
    }

    public function validate($dtoObject, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueDto) {
            throw new UnexpectedTypeException($constraint, UniqueDto::class);
        }

        $entity = $this->getEntity($dtoObject, $constraint);

        if (ArrayUtils::isAssocArray($constraint->fields)) {
            $constraint->errorPath = ArrayUtils::getFirstStringKeyInAssocArray($constraint->fields);
            $constraint->fields = array_values($constraint->fields);
        }

        parent::validate($entity, $constraint);
    }

    private function getEntity($dtoObject, UniqueDto $constraint)
    {
        $mapper = new DtoToEntityMapper($dtoObject);
        $entityClass = $constraint->mapToEntityClass;

        $em = $this->registry->getManager($constraint->em);

        $identifierFieldName = $em->getClassMetadata($constraint->mapToEntityClass)->getSingleIdentifierFieldName();
        if (!$mapper->getDtoReflection()->hasProperty($identifierFieldName)) {
            return $mapper->map($constraint->fields, $entityClass);
        }

        $property = $mapper->getDtoReflection()->getProperty($identifierFieldName);
        $property->setAccessible(true);

        if (null === $id = $property->getValue($dtoObject)) {
            return $mapper->map($constraint->fields, $entityClass);
        }

        if (null === $entity = $em->getRepository($entityClass)->find($id)) {
            throw new EntityNotFoundException(
                sprintf(
                    'Entity of class %s with id %s not found',
                    $constraint->mapToEntityClass,
                    $id
                )
            );
        }

        return $mapper->map($constraint->fields, $entity);
    }
}
