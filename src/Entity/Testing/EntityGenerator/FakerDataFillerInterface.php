<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Testing\EntityGenerator;

use LTS\DsmRuntime\CodeGeneration\NamespaceHelper;
use LTS\DsmRuntime\DoctrineStaticMeta;
use LTS\DsmRuntime\Entity\Interfaces\DataTransferObjectInterface;

interface FakerDataFillerInterface
{
    public function __construct(
        FakerDataFillerFactory $fakerDataFillerFactory,
        DoctrineStaticMeta $testedEntityDsm,
        NamespaceHelper $namespaceHelper,
        array $fakerDataProviderClasses,
        ?float $seed = null
    );

    public function updateDtoWithFakeData(DataTransferObjectInterface $dto): void;

    /**
     * @param DataTransferObjectInterface $dto
     * @param bool                        $isRootDto
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function update(DataTransferObjectInterface $dto, $isRootDto = false): void;
}
