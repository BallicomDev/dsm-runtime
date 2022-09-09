<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\Interfaces\Identity;

use LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects\Identity\FullNameEmbeddableInterface;
use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;

interface HasFullNameEmbeddableInterface extends EntityInterface
{
    public const PROP_FULL_NAME_EMBEDDABLE = 'fullNameEmbeddable';
    public const COLUMN_PREFIX_FULL_NAME   = 'full_name_';

    public function getFullNameEmbeddable(): FullNameEmbeddableInterface;
}
