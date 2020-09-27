<?php

namespace App\Utils;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\Proxy;
use InvalidArgumentException;

class ObjectUtils
{
    /**
     * @param object $object
     * @return bool
     */
    public static function isEntity($object): bool
    {
        if (!is_object($object)) {
            return false;
        }

        if ($object instanceof Proxy) {
            return true;
        }

        $annotationReader = new AnnotationReader();

        return !empty($annotationReader->getClassAnnotation(new \ReflectionClass($object), Entity::class));
    }

    /**
     * @param object $object
     * @return string
     */
    public static function getIdFromEntity($object): string
    {
        if (self::isEntity($object)) {
            return $object->getId();
        }

        throw new InvalidArgumentException('The object is not an entity');
    }
}
