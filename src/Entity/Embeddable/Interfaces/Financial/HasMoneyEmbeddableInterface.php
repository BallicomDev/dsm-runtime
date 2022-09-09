<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\Interfaces\Financial;

use LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects\Financial\MoneyEmbeddableInterface;
use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;

interface HasMoneyEmbeddableInterface extends EntityInterface
{
    public const PROP_MONEY_EMBEDDABLE = 'moneyEmbeddable';
    public const COLUMN_PREFIX_MONEY   = 'money_';

    public function getMoneyEmbeddable(): MoneyEmbeddableInterface;
}
