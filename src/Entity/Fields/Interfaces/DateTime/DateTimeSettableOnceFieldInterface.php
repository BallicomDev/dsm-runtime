<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\DateTime;

use DateTimeImmutable;

interface DateTimeSettableOnceFieldInterface
{
    public const PROP_DATE_TIME_SETTABLE_ONCE = 'dateTimeSettableOnce';

    public const DEFAULT_DATE_TIME_SETTABLE_ONCE = null;

    public function getDateTimeSettableOnce(): ?DateTimeImmutable;
}
