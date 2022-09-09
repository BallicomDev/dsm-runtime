<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Savers;

use LTS\DsmRuntime\Entity\Interfaces\DataTransferObjectInterface;

interface NewUpsertDtoDataModifierInterface
{
    public function addDataToNewlyCreatedDto(DataTransferObjectInterface $dto): void;
}
