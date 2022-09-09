<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\String;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\EnumFieldInterface;

class EnumFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        $minKey = 0;
        $maxKey = count(EnumFieldInterface::ENUM_OPTIONS) - 1;
        $key    = $this->generator->numberBetween($minKey, $maxKey);

        return EnumFieldInterface::ENUM_OPTIONS[$key];
    }
}
