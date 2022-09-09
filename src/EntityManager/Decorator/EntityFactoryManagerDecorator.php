<?php

namespace LTS\DsmRuntime\EntityManager\Decorator;

use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManagerInterface;
use LTS\DsmRuntime\Helper\NamespaceHelper;
use LTS\DsmRuntime\Entity\Factory\EntityFactoryInterface as GenericEntityFactoryInterface;
use LTS\DsmRuntime\EntityManager\Mapping\EntityFactoryAware;
use LTS\DsmRuntime\EntityManager\Mapping\EntityFactoryInterface as EntitySpecificFactory;
use LTS\DsmRuntime\Exception\DoctrineStaticMetaException;

class EntityFactoryManagerDecorator extends EntityManagerDecorator implements EntityFactoryAware
{
    public function addEntityFactory(string $name, EntitySpecificFactory $entityFactory): void
    {
        $metadataFactory = $this->wrapped->getMetadataFactory();
        if ($metadataFactory instanceof EntityFactoryAware) {
            $metadataFactory->addEntityFactory($name, $entityFactory);
        }
    }

    public function addGenericFactory(GenericEntityFactoryInterface $genericFactory): void
    {
        $metadataFactory = $this->wrapped->getMetadataFactory();
        if ($metadataFactory instanceof EntityFactoryAware) {
            $metadataFactory->addGenericFactory($genericFactory);
        }
    }

    public function getRepository($className)
    {
        $namespaceHelper = new NamespaceHelper();
        $repositoryFqn   = $namespaceHelper->getRepositoryqnFromEntityFqn($className);
        throw new DoctrineStaticMetaException(
            'You must not use the Entity manager to get your ' . $className . ' repository, '
            . 'please type hint and dependency inject ' . $repositoryFqn . ' as required'
        );
    }
}
