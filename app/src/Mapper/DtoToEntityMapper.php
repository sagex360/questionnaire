<?php

namespace App\Mapper;

use App\Utils\ArrayUtils;

class DtoToEntityMapper
{
    private $entity;
    private $dto;
    private $entityReflection;
    private $dtoReflection;

    public function __construct($dto)
    {
        $this->dto = $dto;
        $this->dtoReflection = new \ReflectionClass($dto);
    }

    public function map(array $fields, $entity)
    {
        $this->entityReflection = new \ReflectionClass($entity);

        if (is_object($entity)) {
            $this->entity = $entity;
        } else {
            $this->entity = $this->entityReflection->newInstanceWithoutConstructor();
        }

        if (ArrayUtils::isAssocArray($fields)) {
            foreach ($fields as $dtoField => $entityField) {
                $dtoField = is_integer($dtoField) ? $entityField : $dtoField;

                $this->fillField($dtoField, $entityField);
            }
        } else {
            foreach ($fields as $field) {
                $this->fillField($field, $field);
            }
        }

        return $this->entity;
    }

    public function getDtoReflection(): \ReflectionClass
    {
        return $this->dtoReflection;
    }

    private function fillField(string $dtoFieldName, string $entityFieldName)
    {
        $this->checkField($this->entityReflection, $entityFieldName);
        $this->checkField($this->dtoReflection, $dtoFieldName);

        $dtoProperty = $this->dtoReflection->getProperty($dtoFieldName);
        $dtoProperty->setAccessible(true);

        $entityProperty = $this->entityReflection->getProperty($entityFieldName);
        $entityProperty->setAccessible(true);
        $entityProperty->setValue(
            $this->entity,
            $dtoProperty->getValue($this->dto)
        );
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @param string $fieldName
     * @return bool
     */
    private function checkField(\ReflectionClass $reflectionClass, string $fieldName)
    {
        if (!$reflectionClass->hasProperty($fieldName)) {
            throw new \InvalidArgumentException(sprintf(
                'Property %s of entity %s does not exist',
                $fieldName,
                $reflectionClass->name
            ));
        }

        return true;
    }
}
