<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\PrimaryKey;

use LTS\DsmRuntime\Entity\Fields\Factories\UuidFactory;
use Ramsey\Uuid\UuidInterface;

interface UuidPrimaryKeyInterface
{
    public static function buildUuid(UuidFactory $factory): UuidInterface;

    public function getUuid(): UuidInterface;
}
