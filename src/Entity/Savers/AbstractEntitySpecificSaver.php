<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Savers;

use Doctrine\ORM\EntityManagerInterface;
use LTS\DsmRuntime\Helper\NamespaceHelper;
use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;
use LTS\DsmRuntime\Exception\DoctrineStaticMetaException;
use ReflectionException;

use function get_class;
use function str_replace;

abstract class AbstractEntitySpecificSaver extends EntitySaver
{

    /**
     * @var NamespaceHelper
     */
    protected $namespaceHelper;

    public function __construct(EntityManagerInterface $entityManager, NamespaceHelper $namespaceHelper)
    {
        parent::__construct($entityManager);
        $this->namespaceHelper = $namespaceHelper;
    }


    /**
     *
     *
     * @param array|EntityInterface[] $entities
     *
     * @throws DoctrineStaticMetaException
     */
    public function saveAll(array $entities): void
    {
        if ([] === $entities) {
            return;
        }

        foreach ($entities as $entity) {
            $this->checkIsCorrectEntityType($entity);
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }

    /**
     * @param EntityInterface $entity
     *
     * @return void
     * @throws DoctrineStaticMetaException
     */
    protected function checkIsCorrectEntityType(EntityInterface $entity): void
    {
        $entityFqn = $this->getEntityFqn();

        if (!$entity instanceof $entityFqn) {
            $class = get_class($entity);
            $msg   = "[ $class ] is not an instance of [ $entityFqn ]";
            throw new DoctrineStaticMetaException($msg);
        }
    }

    /**
     * Based on the convention that the Entity Specific Saver namespace has been generated,
     * We can do some simple find/replace to get the Entity namespace
     *
     * @return string
     */
    protected function getEntityFqn(): string
    {
        if (null === $this->entityFqn) {
            $this->entityFqn = str_replace(
                '\\Entity\\Savers\\',
                '\\Entities\\',
                $this->namespaceHelper->cropSuffix(static::class, 'Saver')
            );
        }

        return $this->entityFqn;
    }

    /**
     * @param array|EntityInterface[] $entities
     *
     * @throws DoctrineStaticMetaException
     */
    public function removeAll(array $entities): void
    {
        if ([] === $entities) {
            return;
        }
        foreach ($entities as $entity) {
            $this->checkIsCorrectEntityType($entity);
            $this->entityManager->remove($entity);
        }

        $this->entityManager->flush();
    }
}
