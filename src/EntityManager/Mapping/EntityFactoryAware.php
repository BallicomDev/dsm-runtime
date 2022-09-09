<?php

namespace LTS\DsmRuntime\EntityManager\Mapping;

use LTS\DsmRuntime\Entity\Factory\EntityFactoryInterface as GenericEntityFactoryInterface;
use LTS\DsmRuntime\EntityManager\Mapping\EntityFactoryInterface as EntitySpecificFactory;

interface EntityFactoryAware
{
    public function addEntityFactory(
        string $name,
        EntitySpecificFactory $entityFactory
    ): void;

    public function addGenericFactory(GenericEntityFactoryInterface $genericFactory): void;
}
