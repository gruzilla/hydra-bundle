<?php

namespace Hydra\HydraBundle\EntityRepository;

use Hydra\Interfaces\EntityRepositoryInterface,
    Hydra\Mappers\ArrayMapper;

use Doctrine\ORM\EntityManager;

use Doctrine\Common\Annotations\Reader;

class DoctrineEntityRepository implements EntityRepositoryInterface
{
    const SUPPORTED_ID_FIELDS = 1;

    public function __construct(EntityManager $em, Reader $reader)
    {
        $this->em = $em;
        $this->reader = $reader;
    }

    public function fetchOrCreateEntity($className, $data)
    {
        $rep = $this->em->getRepository($className);

        // test input data
        $metadata = $this->em->getMetadataFactory()->getMetadataFor($className);
        $idFields = $metadata->getIdentifier();

        if (self::SUPPORTED_ID_FIELDS !== count($idFields)) {
            throw new \RuntimeException('Entity ' . $className . ' has too many primary keys to work with Hydra.');
        }


        // get value of id from $data
        $idField = $idFields[0];

        $property = $metadata->getReflectionClass()->getProperty($idField);

        $annotation = $this->reader->getPropertyAnnotation($property, 'Hydra\Annotation\Map');

        $value = null;
        $source = $idField;
        if (null !== $annotation) {
            $source = $annotation->getSource();
        }

        $value = ArrayMapper::evalueateArrayQuery($data, $source);


        // find entity in doctrine repository
        $entity = $rep->find($value);

        if (null === $entity) {
            $entity = new $className;
        }


        // return entity
        return $entity;
    }
}