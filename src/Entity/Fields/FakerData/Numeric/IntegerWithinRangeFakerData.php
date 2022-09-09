<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\Numeric;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Numeric\IntegerWithinRangeFieldInterface;

class IntegerWithinRangeFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        return $this->generator->numberBetween(
            IntegerWithinRangeFieldInterface::MIN_INTEGER_WITHIN_RANGE,
            IntegerWithinRangeFieldInterface::MAX_INTEGER_WITHIN_RANGE
        );
    }
}
