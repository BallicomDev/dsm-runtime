<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\Traits\DateTime;

// phpcs:disable Generic.Files.LineLength.TooLong
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use LTS\DsmRuntime\Entity\Fields\Interfaces\DateTime\DateTimeSettableNoDefaultFieldInterface;
use LTS\DsmRuntime\MappingHelper;

// phpcs:enable
/**
 * Trait DateTimeSettableNoDefaultFieldTrait
 *
 * This field is a dateTime that you can set and update the value as you see fit with no defaults
 *
 * @package LTS\DsmRuntime\Entity\Fields\Traits\DateTime
 */
trait DateTimeSettableNoDefaultFieldTrait
{

    /**
     * @var DateTimeImmutable|null
     */
    private $dateTimeSettableNoDefault;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @param ClassMetadataBuilder $builder
     */
    public static function metaForDateTimeSettableNoDefault(ClassMetadataBuilder $builder): void
    {
        MappingHelper::setSimpleDatetimeFields(
            [DateTimeSettableNoDefaultFieldInterface::PROP_DATE_TIME_SETTABLE_NO_DEFAULT],
            $builder,
            DateTimeSettableNoDefaultFieldInterface::DEFAULT_DATE_TIME_SETTABLE_NO_DEFAULT
        );
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDateTimeSettableNoDefault(): ?DateTimeImmutable
    {
        if (null === $this->dateTimeSettableNoDefault) {
            return DateTimeSettableNoDefaultFieldInterface::DEFAULT_DATE_TIME_SETTABLE_NO_DEFAULT;
        }

        return $this->dateTimeSettableNoDefault;
    }

    /**
     * @param DateTimeImmutable|null $dateTimeSettableNoDefault
     *
     * @return self
     */
    private function setDateTimeSettableNoDefault(?DateTimeImmutable $dateTimeSettableNoDefault): self
    {
        $this->updatePropertyValue(
            DateTimeSettableNoDefaultFieldInterface::PROP_DATE_TIME_SETTABLE_NO_DEFAULT,
            $dateTimeSettableNoDefault
        );

        return $this;
    }
}
