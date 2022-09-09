<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\String;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\UniqueStringFieldInterface;

class UniqueStringFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        /** @phpstan-ignore-next-line  - says method doesn't exist but it does */
        return $this->generator->unique()->text(UniqueStringFieldInterface::LENGTH_UNIQUE_STRING);
    }
}
