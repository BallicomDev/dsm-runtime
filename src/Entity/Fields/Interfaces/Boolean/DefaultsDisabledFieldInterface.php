<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\Boolean;

interface DefaultsDisabledFieldInterface
{
    public const PROP_DEFAULTS_DISABLED = 'defaultsDisabled';

    public const DEFAULT_DEFAULTS_DISABLED = false;

    public function isDefaultsDisabled(): bool;
}
