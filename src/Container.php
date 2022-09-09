<?php

declare(strict_types=1);

namespace LTS\DsmRuntime;

// phpcs:disable
#use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\SchemaValidator;
use LTS\DsmRuntime\Helper\NamespaceHelper;
use LTS\DsmRuntime\Helper\ReflectionHelper;
use LTS\DsmRuntime\Helper\TypeHelper;
use LTS\DsmRuntime\Entity\DataTransferObjects\DtoFactory;
use LTS\DsmRuntime\Entity\Factory\EntityDependencyInjector;
use LTS\DsmRuntime\Entity\Factory\EntityFactory;
use LTS\DsmRuntime\Entity\Factory\EntityFactoryInterface;
use LTS\DsmRuntime\Entity\Fields\Factories\UuidFactory;
use LTS\DsmRuntime\Entity\Interfaces\Validation\EntityDataValidatorInterface;
use LTS\DsmRuntime\Entity\Repositories\RepositoryFactory;
use LTS\DsmRuntime\Entity\Savers\BulkEntitySaver;
use LTS\DsmRuntime\Entity\Savers\BulkEntityUpdater;
use LTS\DsmRuntime\Entity\Savers\BulkSimpleEntityCreator;
use LTS\DsmRuntime\Entity\Savers\EntitySaver;
use LTS\DsmRuntime\Entity\Savers\EntitySaverFactory;
use LTS\DsmRuntime\Entity\Testing\EntityGenerator\FakerDataFillerFactory;
use LTS\DsmRuntime\Entity\Testing\EntityGenerator\TestEntityGeneratorFactory;
use LTS\DsmRuntime\Entity\Testing\Fixtures\FixturesHelperFactory;
use LTS\DsmRuntime\Entity\Validation\EntityDataValidator;
use LTS\DsmRuntime\Entity\Validation\EntityDataValidatorFactory;
use LTS\DsmRuntime\Entity\Validation\Initialiser;
use LTS\DsmRuntime\EntityManager\EntityManagerFactory;
use LTS\DsmRuntime\Exception\DoctrineStaticMetaException;
use LTS\DsmRuntime\Schema\Database;
use LTS\DsmRuntime\Schema\MysqliConnectionFactory;
use LTS\DsmRuntime\Schema\Schema;
use LTS\DsmRuntime\Schema\UuidFunctionPolyfill;
#use ProjectServiceContainer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use Symfony\Component\Validator\ContainerConstraintValidatorFactory;

#use Doctrine\Common\Cache\FilesystemCache;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\UpToDateCommand;
//use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
//use Symfony\Component\Validator\Mapping\Cache\DoctrineCache;

// phpcs:enable

/**
 * Class Container
 *
 * @package LTS\DsmRuntime
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Container implements ContainerInterface
{
    /**
     * This is the list of services managed by this container
     *
     * This list is used to also generate a PHPStorm meta data file which assists with dynamic type hinting when using
     * the container as a service locator
     *
     * @see ./../../.phpstorm.meta.php/container.meta.php
     */
    public const SERVICES = [
        \Ramsey\Uuid\UuidFactory::class,
        BulkEntitySaver::class,
        BulkEntityUpdater::class,
        BulkSimpleEntityCreator::class,
        Config::class,
        ContainerConstraintValidatorFactory::class,
        Database::class,
        DtoFactory::class,
        EntityDataValidator::class,
        EntityDataValidatorFactory::class,
        EntityDependencyInjector::class,
        EntityFactory::class,
        EntityManagerFactory::class,
        EntityManagerInterface::class,
        EntitySaver::class,
        EntitySaverFactory::class,
        FakerDataFillerFactory::class,
        Filesystem::class,
        Finder::class,
        FixturesHelperFactory::class,
        MysqliConnectionFactory::class,
        NamespaceHelper::class,
        ReflectionHelper::class,
        RelationshipHelper::class,
        RepositoryFactory::class,
        Schema::class,
        SchemaTool::class,
        SchemaValidator::class,
        TestEntityGeneratorFactory::class,
        TypeHelper::class,
        UuidFactory::class,
        UuidFunctionPolyfill::class,
        Initialiser::class,
        DoctrineProvider::class,
        ArrayAdapter::class,
        FilesystemAdapter::class,
    ];

    public const ALIASES = [
        EntityFactoryInterface::class              => EntityFactory::class,
        EntityDataValidatorInterface::class        => EntityDataValidator::class,
        ConstraintValidatorFactoryInterface::class => ContainerConstraintValidatorFactory::class,
    ];

    public const NOT_SHARED_SERVICES = [
    ];


    /**
     * The directory that container cache files will be stored
     */
    public const CACHE_PATH = __DIR__ . '/../cache/';

    public const SYMFONY_CACHE_PATH = self::CACHE_PATH . '/container.symfony.php';

    /**
     * @var bool
     */
    private $useCache = false;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param bool $useCache
     *
     * @return Container
     */
    public function setUseCache(bool $useCache): Container
    {
        $this->useCache = $useCache;

        return $this;
    }

    /**
     * @param array $server - normally you would pass in $_SERVER
     *
     * @throws DoctrineStaticMetaException
     */
    public function buildSymfonyContainer(array $server): void
    {
        if (true === $this->useCache && file_exists(self::SYMFONY_CACHE_PATH)) {
            /** @noinspection PhpIncludeInspection */
            require self::SYMFONY_CACHE_PATH;
            $this->setContainer(new ProjectServiceContainer());

            return;
        }

        try {
            $container = new ContainerBuilder();
            $this->addConfiguration($container, $server);
            $container->compile();
            $this->setContainer($container);
            $dumper = new PhpDumper($container);
            file_put_contents(self::SYMFONY_CACHE_PATH, $dumper->dump());
        } catch (ServiceNotFoundException | InvalidArgumentException $e) {
            throw new DoctrineStaticMetaException(
                'Exception building the container: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Set a container instance
     *
     * @param ContainerInterface $container
     *
     * @return $this
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Build all the definitions, alias and other configuration for this container. Each of these steps need to be
     * carried out to allow the everything to work, however you may wish to change individual bits. Therefore this
     * method has been made final, but the individual methods can be overwritten if you extend off the class
     *
     * @param ContainerBuilder $containerBuilder
     * @param array            $server
     *
     * @throws InvalidArgumentException
     * @throws ServiceNotFoundException
     */
    final public function addConfiguration(ContainerBuilder $containerBuilder, array $server): void
    {
        $this->autoWireServices($containerBuilder);
        $this->defineConfig($containerBuilder, $server);
        $this->defineCache($containerBuilder, $server);
        $this->defineEntityManager($containerBuilder);
        $this->configureValidationComponents($containerBuilder);
        $this->defineAliases($containerBuilder);
        $this->registerCustomFakerDataFillers($containerBuilder);
    }

    /**
     * This takes every class from the getServices method, auto wires them and marks them as public. You may wish to
     * override this if you want to mark certain classes as private
     *
     * @param ContainerBuilder $containerBuilder
     */
    public function autoWireServices(ContainerBuilder $containerBuilder): void
    {
        $services = $this->getServices();
        foreach ($services as $class) {
            $containerBuilder->autowire($class, $class)->setPublic(true);
        }
    }

    /**
     * This is a simple wrapper around the class constants. You can use this to add, remove, or replace individual
     * services that will be auto wired
     *
     * @return array
     */
    public function getServices(): array
    {
        return self::SERVICES;
    }

    /**
     * This is used to auto wire the config interface. It sets the $server param as a constructor argument and then
     * sets the concrete class as the implementation for the Interface. Override this if you wish to use different
     * logic for where the config comes from
     *
     * @param ContainerBuilder $containerBuilder
     * @param array            $server
     */
    public function defineConfig(ContainerBuilder $containerBuilder, array $server): void
    {
        $containerBuilder->getDefinition(Config::class)->setArgument('$server', $this->configVars($server));
        $containerBuilder->setAlias(ConfigInterface::class, Config::class);
    }

    /**
     * Take the $server array, normally a copy of $_SERVER, and pull out just the bits required by config
     *
     * @param array $server
     *
     * @return array
     */
    protected function configVars(array $server): array
    {
        $return = array_intersect_key(
            $server,
            array_flip(ConfigInterface::PARAMS)
        );

        return $return;
    }

    /**
     * This is used to auto wire the doctrine cache. If we are in dev mode then this will always use the Array Cache,
     * if not then the cache will be set to what is in the $server array. Override this method if you wish to use
     * different logic to handle caching
     *
     * @param ContainerBuilder $containerBuilder
     * @param array            $server
     */
    public function defineCache(ContainerBuilder $containerBuilder, array $server): void
    {
        $cacheDriver = $server[Config::PARAM_DOCTRINE_CACHE_DRIVER] ?? Config::DEFAULT_DOCTRINE_CACHE_DRIVER;
        $containerBuilder->autowire($cacheDriver)->setPublic(true);
        $this->configureFilesystemCache($containerBuilder);
        /**
         * Which Cache Driver is used for the Cache Interface?
         *
         * If Dev mode, we always use the Array Cache
         *
         * Otherwise, we use the Configured Cache driver (which defaults to Array Cache)
         */
        $cache = ($server[Config::PARAM_DEVMODE] ?? false) ? ArrayAdapter::class : $cacheDriver;
        $containerBuilder->getDefinition(DoctrineProvider::class)
                         ->setFactory([DoctrineProvider::class, 'wrap'])
                         ->addArgument(new Reference($cache))
                         ->setPublic(true);
        $containerBuilder->setAlias(Cache::class, DoctrineProvider::class)->setPublic(true);
    }

    private function configureFilesystemCache(ContainerBuilder $containerBuilder): void
    {
        $config = $this->getConfig($containerBuilder);
        $containerBuilder->getDefinition(FilesystemAdapter::class)
                         ->setArguments([
                                            $config->get(Config::PARAM_FILESYSTEM_CACHE_NAMESPACE),
                                            0,
                                            $config->get(Config::PARAM_FILESYSTEM_CACHE_PATH),
                                        ])
                         ->setPublic(true);
    }

    private function getConfig(ContainerBuilder $containerBuilder): Config
    {
        return $containerBuilder->get(Config::class);
    }

    /**
     * This is used to auto wire the entity manager. It first adds the DSM factory as the factory for the class, and
     * sets the Entity Manager as the implementation of the interface. Overrider this if you want to use your own
     * factory to create and configure the entity manager
     *
     * @param ContainerBuilder $container
     */
    public function defineEntityManager(ContainerBuilder $container): void
    {
        $container->getDefinition(EntityManagerInterface::class)
                  ->addArgument(new Reference(Config::class))
                  ->setFactory(
                      [
                          new Reference(EntityManagerFactory::class),
                          'getEntityManager',
                      ]
                  );
    }

    /**
     * Ensure we are using the container constraint validator factory so that custom validators with dependencies can
     * simply declare them as normal. Note that you will need to define each custom validator as a service in your
     * container.
     *
     * @param ContainerBuilder $containerBuilder
     */
    public function configureValidationComponents(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->getDefinition(EntityDataValidator::class)
                         ->setFactory(
                             [
                                 new Reference(EntityDataValidatorFactory::class),
                                 'buildEntityDataValidator',
                             ]
                         )->setShared(false);
    }

    public function defineAliases(ContainerBuilder $containerBuilder): void
    {
        foreach (self::ALIASES as $interface => $service) {
            $containerBuilder->setAlias($interface, $service)->setPublic(true);
        }
    }

    private function registerCustomFakerDataFillers(ContainerBuilder $containerBuilder): void
    {
        $config = $this->getConfig($containerBuilder);
        $path   = $config->get(Config::PARAM_ENTITIES_CUSTOM_DATA_FILLER_PATH);
        if (!is_dir($path)) {
            return;
        }
        /** @var Finder $finder */
        $finder        = $containerBuilder->get(Finder::class);
        $files         = $finder->files()->name('*FakerDataFiller.php')->in($path);
        $baseNameSpace = $config->get(Config::PARAM_PROJECT_ROOT_NAMESPACE);
        $mappings      = [];
        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $dataFillerClassName = $baseNameSpace . '\\Assets\\Entity\\FakerDataFillers';
            $entityClassName     = $baseNameSpace . '\\Entities';
            $relativePath        = str_replace('/', '\\', $file->getRelativePath());
            if ($relativePath !== '') {
                $dataFillerClassName .= '\\' . $relativePath;
                $entityClassName     .= '\\' . $relativePath;
            }
            $fileName                   = $file->getBasename('.php');
            $dataFillerClassName        .= '\\' . $fileName;
            $entityClassName            .= '\\' . str_replace('FakerDataFiller', '', $fileName);
            $mappings[$entityClassName] = $dataFillerClassName;
        }

        $containerBuilder->getDefinition(FakerDataFillerFactory::class)
                         ->addMethodCall('setCustomFakerDataFillersFqns', [$mappings]);
    }

    /**
     * Some service should not be Singletons (shared) but should always be a new instance
     *
     * @param ContainerBuilder $containerBuilder
     */
    public function updateNotSharedServices(ContainerBuilder $containerBuilder): void
    {
        foreach (self::NOT_SHARED_SERVICES as $service) {
            $containerBuilder->getDefinition($service)->setShared(false);
        }
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @throws DoctrineStaticMetaException
     */
    public function get(string $id)
    {
        try {
            return $this->container->get($id);
        } catch (ContainerExceptionInterface | NotFoundExceptionInterface | \ReflectionException $e) {
            throw new DoctrineStaticMetaException(
                get_class($e) . ' getting service ' . $id . ': ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param string $id
     * @SuppressWarnings(PHPMD.ShortVariable)
     *
     * @return bool|void
     */
    public function has(string $id)
    {
        return $this->container->has($id);
    }
}
