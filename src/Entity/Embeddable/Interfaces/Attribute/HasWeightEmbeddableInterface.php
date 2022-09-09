<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\Interfaces\Attribute;

use LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects\Attribute\WeightEmbeddableInterface;

interface HasWeightEmbeddableInterface
{
    public const PROP_WEIGHT_EMBEDDABLE = 'weightEmbeddable';
    public const COLUMN_PREFIX_WEIGHT   = 'weight_';

    public function getWeightEmbeddable(): WeightEmbeddableInterface;
}
