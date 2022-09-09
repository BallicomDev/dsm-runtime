<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\FakerData\Geo;

use LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects\Geo\AddressEmbeddableInterface;
use LTS\DsmRuntime\Entity\Embeddable\Objects\Geo\AddressEmbeddable;
use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class AddressEmbeddableFakerData extends AbstractFakerDataProvider
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __invoke()
    {
        return AddressEmbeddable::create(
            [
                AddressEmbeddableInterface::EMBEDDED_PROP_HOUSE_NUMBER => (string)$this->generator->numberBetween(
                    1,
                    1000
                ),
                AddressEmbeddableInterface::EMBEDDED_PROP_HOUSE_NAME   => $this->generator->name,
                AddressEmbeddableInterface::EMBEDDED_PROP_STREET       => $this->generator->streetName,
                AddressEmbeddableInterface::EMBEDDED_PROP_CITY         => $this->generator->city,
                AddressEmbeddableInterface::EMBEDDED_PROP_POSTAL_AREA  => $this->generator->city,
                AddressEmbeddableInterface::EMBEDDED_PROP_POSTAL_CODE  => $this->generator->postcode,
                AddressEmbeddableInterface::EMBEDDED_PROP_COUNTRY_CODE => $this->generator->countryCode,
            ]
        );
    }
}
