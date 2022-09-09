<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\String;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class NullableStringFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        return mt_rand(0, 1) === 1 ? null : $this->generator->realText(100);
    }
}
