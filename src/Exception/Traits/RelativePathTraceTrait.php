<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Exception\Traits;

use LTS\DsmRuntime\Config;
use LTS\DsmRuntime\Exception\DoctrineStaticMetaException;

trait RelativePathTraceTrait
{
    /**
     * @return string
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getTraceAsStringRelativePath(): string
    {
        try {
            return "\n\n" . str_replace(
                Config::getProjectRootDirectory(),
                '',
                parent::getTraceAsString()
            ) . "\n\n";
        } catch (DoctrineStaticMetaException $e) {
            return parent::getTraceAsString();
        }
    }
}
