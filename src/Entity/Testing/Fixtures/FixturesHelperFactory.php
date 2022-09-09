<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Testing\Fixtures;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManagerInterface;
use LTS\DsmRuntime\Helper\NamespaceHelper;
use LTS\DsmRuntime\Entity\Savers\EntitySaverFactory;
use LTS\DsmRuntime\Entity\Testing\EntityGenerator\TestEntityGeneratorFactory;
use LTS\DsmRuntime\Schema\Database;
use LTS\DsmRuntime\Schema\Schema;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class FixturesHelperFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Database
     */
    private $database;
    /**
     * @var Schema
     */
    private $schema;
    /**
     * @var FilesystemAdapter
     */
    private $cache;
    /**
     * @var EntitySaverFactory
     */
    private $entitySaverFactory;
    /**
     * @var NamespaceHelper
     */
    private $namespaceHelper;
    /**
     * @var TestEntityGeneratorFactory
     */
    private $testEntityGeneratorFactory;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        EntityManagerInterface $entityManager,
        Database $database,
        Schema $schema,
        FilesystemAdapter $cache,
        EntitySaverFactory $entitySaverFactory,
        NamespaceHelper $namespaceHelper,
        TestEntityGeneratorFactory $testEntityGeneratorFactory,
        ContainerInterface $container
    ) {
        $this->entityManager              = $entityManager;
        $this->database                   = $database;
        $this->schema                     = $schema;
        $this->cache                      = $cache;
        $this->entitySaverFactory         = $entitySaverFactory;
        $this->namespaceHelper            = $namespaceHelper;
        $this->testEntityGeneratorFactory = $testEntityGeneratorFactory;
        $this->container                  = $container;
    }

    public function getFixturesHelper(string $cacheKey = null): FixturesHelper
    {
        return new FixturesHelper(
            $this->entityManager,
            $this->database,
            $this->schema,
            $this->cache,
            $this->entitySaverFactory,
            $this->namespaceHelper,
            $this->testEntityGeneratorFactory,
            $this->container,
            $cacheKey
        );
    }
}
