<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\String;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class UrlFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        //to prevent issues when using as an archetype, otherwise this gets replaced with the new field property name
        $property = 'u' . 'rl';

        /** @phpstan-ignore-next-line  - variable property */
        return $this->generator->$property;
    }
}
