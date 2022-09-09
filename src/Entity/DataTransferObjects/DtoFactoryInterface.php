<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\DataTransferObjects;

use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;

interface DtoFactoryInterface
{
    public function createEmptyDtoFromEntityFqn(string $entityFqn);
}
