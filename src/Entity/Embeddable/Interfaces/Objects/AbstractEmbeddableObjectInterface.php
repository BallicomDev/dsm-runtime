<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects;

use Doctrine\ORM\Mapping\ClassMetadata;
use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;
use LTS\DsmRuntime\Entity\Interfaces\ImplementNotifyChangeTrackingPolicyInterface;

interface AbstractEmbeddableObjectInterface
{
    /**
     * @param ClassMetadata<EntityInterface> $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata): void;

    /**
     * @param array<int|string,mixed> $properties
     */
    public static function create(array $properties): static;

    public function setOwningEntity(ImplementNotifyChangeTrackingPolicyInterface $entity): void;

    public function __toString(): string;
}
