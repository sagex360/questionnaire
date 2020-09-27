<?php

namespace App\Serializer;

use App\Annotation\ConvertUuidToEntity;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EntityNormalizer extends ObjectNormalizer
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @required
     *
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return false;
        if (is_string($data) && Uuid::isValid($data)) {
            return true;
        }

        return array_filter($data, fn($item) => is_string($item) && Uuid::isValid($item));
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $reflectionClass = new \ReflectionClass($type);
        $reader = new AnnotationReader();
        foreach ($data as $key => &$item) {
            if (is_string($item) && Uuid::isValid($item)) {
                if (!$reflectionClass->hasProperty($key)) {
                    continue;
                }

                $property = $reflectionClass->getProperty($key);
                if (null !== $annotation = $reader->getPropertyAnnotation($property, ConvertUuidToEntity::class)) {
                    $item = $this->em->find($annotation->class, $item);
                }
            }
        }

        return parent::denormalize($data, $type, $format, $context);
    }
}
