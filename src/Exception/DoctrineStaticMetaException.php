<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Exception;

use LTS\DsmRuntime\Exception\Traits\RelativePathTraceTrait;
use Exception;

class DoctrineStaticMetaException extends Exception
{
    use RelativePathTraceTrait;
}
