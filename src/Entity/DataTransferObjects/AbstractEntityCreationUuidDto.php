<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\DataTransferObjects;

use LTS\DsmRuntime\Entity\Fields\Factories\UuidFactory;
use LTS\DsmRuntime\Entity\Interfaces\DataTransferObjectInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Extend from this class when making small anonymous DTO classes
 *
 * This version will generate an ordered time Uuid which should be used for Entities that implement (the default)
 * \LTS\DsmRuntime\Entity\Fields\Traits\PrimaryKey\UuidFieldTrait
 */
abstract class AbstractEntityCreationUuidDto implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private static $entityFqn;
    /**
     * @var UuidInterface
     */
    private $id;

    public function __construct(string $entityFqn, UuidFactory $idFactory)
    {
        self::$entityFqn = $entityFqn;
        $this->id        = $entityFqn::buildUuid($idFactory);
    }

    public static function getEntityFqn(): string
    {
        return self::$entityFqn;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
