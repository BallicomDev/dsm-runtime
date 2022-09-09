<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\String;

interface SettableUuidFieldInterface
{
    public const PROP_SETTABLE_UUID = 'settableUuid';

    public const DEFAULT_SETTABLE_UUID = null;

    public function getSettableUuid(): ?string;
}
