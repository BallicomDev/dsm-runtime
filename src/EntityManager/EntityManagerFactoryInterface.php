<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use LTS\DsmRuntime\ConfigInterface;

interface EntityManagerFactoryInterface
{
    public function getEntityManager(
        ConfigInterface $config
    ): EntityManagerInterface;
}
