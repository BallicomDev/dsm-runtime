<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Interfaces;

use LTS\DsmRuntime\Entity as DSM;
use JsonSerializable;

interface EntityInterface extends
    EntityData,
    UsesPHPMetaDataInterface,
    ValidatedEntityInterface,
    ImplementNotifyChangeTrackingPolicyInterface,
    AlwaysValidInterface,
    DSM\Fields\Interfaces\PrimaryKey\IdFieldInterface,
    JsonSerializable
{

}
