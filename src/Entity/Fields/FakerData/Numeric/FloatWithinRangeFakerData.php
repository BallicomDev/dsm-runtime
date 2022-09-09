<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\Numeric;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Numeric\FloatWithinRangeFieldInterface;

class FloatWithinRangeFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        return $this->generator->randomFloat(
            2,
            FloatWithinRangeFieldInterface::MIN_FLOAT_WITHIN_RANGE,
            FloatWithinRangeFieldInterface::MAX_FLOAT_WITHIN_RANGE
        );
    }
}
