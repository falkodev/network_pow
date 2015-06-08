<?php

namespace AppBundle\Manager;

use HireVoice\Neo4j\EntityManager;
use HireVoice\Neo4j\Repository;

abstract class BaseManager
{
    /** @var EntityManager $em */
    protected $em;

    /** @var  Repository $repository */
    protected $repository;

    protected $entityClass;

    public function persist($entity)
    {
        $this->em->persist($entity);
    }

    public function flush()
    {
        $this->em->flush();
    }

    /**
     * @param $entity
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Creates new entity
     *
     * @return mixed
     */
    public function createNew()
    {
        return new $this->entityClass();
    }

    /**
     * @param GraphManager $graphManager
     */
    public function setEntityManager(GraphManager $graphManager)
    {
        $this->em = $graphManager;
    }

    /**
     * @param $entityClassName
     * @throws \HireVoice\Neo4j\Exception
     */
    public function setEntityClassName($entityClassName)
    {
        $this->entityClass = $entityClassName;
        $this->repository  = $this->em->getRepository($entityClassName);
    }
}
