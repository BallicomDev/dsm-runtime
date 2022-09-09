<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\String;

use LTS\DsmRuntime\Schema\Database;

interface UniqueStringFieldInterface
{
    public const PROP_UNIQUE_STRING = 'uniqueString';

    public const DEFAULT_UNIQUE_STRING = 'NOT SET';

    public const LENGTH_UNIQUE_STRING = Database::MAX_VARCHAR_LENGTH;

    public function getUniqueString(): ?string;
}
