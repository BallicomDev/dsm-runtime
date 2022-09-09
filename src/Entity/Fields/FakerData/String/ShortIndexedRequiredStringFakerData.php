<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\String;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class ShortIndexedRequiredStringFakerData extends AbstractFakerDataProvider
{
    public function __invoke(): string
    {
        /** @phpstan-ignore-next-line  - says method doesn't exist but it does */
        return $this->generator->unique()->uuid;
    }
}
