<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\Interfaces\Geo;

use LTS\DsmRuntime\Entity\Embeddable\Interfaces\Objects\Geo\AddressEmbeddableInterface;
use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;

interface HasAddressEmbeddableInterface extends EntityInterface
{
    public const PROP_ADDRESS_EMBEDDABLE = 'addressEmbeddable';
    public const COLUMN_PREFIX_ADDRESS   = 'address_';

    public function getAddressEmbeddable(): AddressEmbeddableInterface;
}
