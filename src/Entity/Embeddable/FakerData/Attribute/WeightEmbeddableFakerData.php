<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\FakerData\Attribute;

use LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects\Attribute\WeightEmbeddableInterface;
use LTS\DsmRuntime\Entity\Embeddable\Objects\Attribute\WeightEmbeddable;
use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class WeightEmbeddableFakerData extends AbstractFakerDataProvider
{

    /**
     * This magic method means that the object is callable like a closure,
     * and when that happens this invoke method is called.
     *
     * This method should return your fake data. You can use the generator to pull fake data from if that is useful
     *
     * @return mixed
     */
    public function __invoke()
    {
        $unitHighestKey = count(WeightEmbeddableInterface::VALID_UNITS) - 1;
        $unitKey        = $this->generator->numberBetween(0, $unitHighestKey);
        $embeddable     = new WeightEmbeddable(
            WeightEmbeddableInterface::VALID_UNITS[$unitKey],
            $this->generator->randomFloat()
        );

        return $embeddable;
    }
}
