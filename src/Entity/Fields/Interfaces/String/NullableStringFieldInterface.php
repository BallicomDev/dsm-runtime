<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\String;

interface NullableStringFieldInterface
{
    public const PROP_NULLABLE_STRING = 'nullableString';

    public const DEFAULT_NULLABLE_STRING = null;

    public function getNullableString(): ?string;
}
