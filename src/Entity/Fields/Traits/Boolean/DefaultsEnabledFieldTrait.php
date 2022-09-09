<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Traits\Boolean;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Boolean\DefaultsEnabledFieldInterface;
use LTS\DsmRuntime\MappingHelper;

trait DefaultsEnabledFieldTrait
{

    /**
     * @var bool
     */
    private $defaultsEnabled = DefaultsEnabledFieldInterface::DEFAULT_DEFAULTS_ENABLED;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @param ClassMetadataBuilder $builder
     */
    public static function metaForDefaultsEnabled(ClassMetadataBuilder $builder): void
    {
        MappingHelper::setSimpleBooleanFields(
            [DefaultsEnabledFieldInterface::PROP_DEFAULTS_ENABLED],
            $builder,
            DefaultsEnabledFieldInterface::DEFAULT_DEFAULTS_ENABLED
        );
    }

    /**
     * @return bool
     */
    public function isDefaultsEnabled(): bool
    {
        if (null === $this->defaultsEnabled) {
            return DefaultsEnabledFieldInterface::DEFAULT_DEFAULTS_ENABLED;
        }

        return $this->defaultsEnabled;
    }

    /**
     * @param bool|null $defaultsEnabled
     *
     * @return self
     */
    private function setDefaultsEnabled(bool $defaultsEnabled): self
    {
        $this->updatePropertyValue(
            DefaultsEnabledFieldInterface::PROP_DEFAULTS_ENABLED,
            $defaultsEnabled
        );

        return $this;
    }

    private function initDefaultsEnabled(): void
    {
        $this->defaultsEnabled = DefaultsEnabledFieldInterface::DEFAULT_DEFAULTS_ENABLED;
    }
}
