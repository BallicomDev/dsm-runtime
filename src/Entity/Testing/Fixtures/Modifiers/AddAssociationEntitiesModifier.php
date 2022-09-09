<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Testing\Fixtures\Modifiers;

use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;
use LTS\DsmRuntime\Entity\Testing\EntityGenerator\TestEntityGenerator;
use LTS\DsmRuntime\Entity\Testing\EntityGenerator\TestEntityGeneratorFactory;
use LTS\DsmRuntime\Entity\Testing\Fixtures\FixtureEntitiesModifierInterface;

/**
 * Use this modifier along when creating your Fixture instance to generate fixtures with all associations set
 */
class AddAssociationEntitiesModifier implements FixtureEntitiesModifierInterface
{
    /**
     * @var TestEntityGeneratorFactory
     */
    private $testEntityGeneratorFactory;

    /**
     * @var TestEntityGenerator
     */
    private $testEntityGenerator;

    public function __construct(TestEntityGeneratorFactory $testEntityGeneratorFactory)
    {
        $this->testEntityGeneratorFactory = $testEntityGeneratorFactory;
    }

    public function modifyEntities(array &$entities): void
    {
        foreach ($entities as $entity) {
            $this->addAssociationEntities($entity);
        }
    }

    private function addAssociationEntities(EntityInterface $entity): void
    {
        $this->getTestEntityGeneratorForEntity($entity)->addAssociationEntities($entity);
    }

    private function getTestEntityGeneratorForEntity(EntityInterface $entity): TestEntityGenerator
    {
        if ($this->testEntityGenerator instanceof TestEntityGenerator) {
            return $this->testEntityGenerator;
        }
        $this->testEntityGenerator = $this->testEntityGeneratorFactory->createForEntityFqn(
            $entity::getEntityFqn()
        );

        return $this->testEntityGenerator;
    }
}
