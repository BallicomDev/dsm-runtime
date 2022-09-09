<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\FakerData\Financial;

use LTS\DsmRuntime\Entity\Embeddable\Objects\Financial\MoneyEmbeddable;
use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class MoneyEmbeddableFakerData extends AbstractFakerDataProvider
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __invoke()
    {
        return MoneyEmbeddable::create(
            [
                $this->generator->randomNumber(),
                $this->generator->currencyCode,
            ]
        );
    }
}
