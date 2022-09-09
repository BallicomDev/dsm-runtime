<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Repositories;

use Doctrine\ORM\QueryBuilder;
use LTS\DsmRuntime\Entity\Interfaces\EntityInterface;
use LTS\DsmRuntime\MappingHelper;
use Ramsey\Uuid\UuidInterface;

class UuidQueryBuilder extends QueryBuilder
{
    public function setParameter($key, $value, $type = null): self
    {
        if ($value instanceof EntityInterface) {
            $value = $value->getId();
        }
        if ($value instanceof UuidInterface) {
            if (null === $type) {
                $type = MappingHelper::TYPE_UUID;
            }
            $value = $value->toString();
        }

        parent::setParameter($key, $value, $type);

        return $this;
    }
}
