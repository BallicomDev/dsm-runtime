<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Exception;

use LTS\DsmRuntime\Exception\Traits\RelativePathTraceTrait;

class ConfigException extends DoctrineStaticMetaException
{
    use RelativePathTraceTrait;
}
