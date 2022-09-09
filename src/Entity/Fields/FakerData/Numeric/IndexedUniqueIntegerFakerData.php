<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\Numeric;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;
use LTS\DsmRuntime\Schema\Database;

class IndexedUniqueIntegerFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        /** @phpstan-ignore-next-line  - says method doesn't exist but it does */
        return $this->generator->unique()->numberBetween(0, Database::MAX_INT_VALUE);
    }
}
