<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Interfaces\String;

interface IsbnFieldInterface
{
    public const PROP_ISBN = 'isbn';

    public const DEFAULT_ISBN = null;

    public function getIsbn(): ?string;
}
