<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Testing;

use LTS\DsmRuntime\Entity\Fields\FakerData\Binary\BinaryUuidFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\Numeric\FloatWithinRangeFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\Numeric\IndexedUniqueIntegerFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\Numeric\IntegerWithinRangeFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\BusinessIdentifierCodeFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\CountryCodeFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\DomainNameFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\EmailAddressFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\EnumFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\IpAddressFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\IsbnFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\LocaleIdentifierFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\NullableStringFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\SettableUuidFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\ShortIndexedRequiredStringFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\UnicodeLanguageIdentifierFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\UniqueEnumFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\UniqueStringFakerData;
use LTS\DsmRuntime\Entity\Fields\FakerData\String\UrlFakerData;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Binary\BinaryUuidFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Numeric\FloatWithinRangeFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Numeric\IndexedUniqueIntegerFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\Numeric\IntegerWithinRangeFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\BusinessIdentifierCodeFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\CountryCodeFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\DomainNameFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\EmailAddressFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\EnumFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\IpAddressFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\IsbnFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\LocaleIdentifierFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\NullableStringFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\SettableUuidFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\ShortIndexedRequiredStringFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\UnicodeLanguageIdentifierFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\UniqueEnumFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\UniqueStringFieldInterface;
use LTS\DsmRuntime\Entity\Fields\Interfaces\String\UrlFieldInterface;

interface EntityTestInterface
{
    /**
     * The function name that is called to get the instance of EntityManager
     */
    public const GET_ENTITY_MANAGER_FUNCTION_NAME = 'dsmGetEntityManagerFactory';

    /**
     * Faker can be seeded with a number which makes the generation deterministic
     * This helps to avoid tests that fail randomly
     * If you do want randomness, override this and set it to null
     */
    public const SEED = 100111991161141051101013211511697116105993210910111697.0;

    /**
     * Standard library faker data provider FQNs
     *
     * This const should be overridden in your child class and extended with any project specific field data providers
     * in addition to the standard library
     *
     * The key is the column/property name and the value is the FQN for the data provider
     */
    // phpcs:disable
    public const FAKER_DATA_PROVIDERS = [
        BusinessIdentifierCodeFieldInterface::PROP_BUSINESS_IDENTIFIER_CODE          => BusinessIdentifierCodeFakerData::class,
        CountryCodeFieldInterface::PROP_COUNTRY_CODE                                 => CountryCodeFakerData::class,
        EmailAddressFieldInterface::PROP_EMAIL_ADDRESS                               => EmailAddressFakerData::class,
        EnumFieldInterface::PROP_ENUM                                                => EnumFakerData::class,
        IpAddressFieldInterface::PROP_IP_ADDRESS                                     => IpAddressFakerData::class,
        IsbnFieldInterface::PROP_ISBN                                                => IsbnFakerData::class,
        LocaleIdentifierFieldInterface::PROP_LOCALE_IDENTIFIER                       => LocaleIdentifierFakerData::class,
        NullableStringFieldInterface::PROP_NULLABLE_STRING                           => NullableStringFakerData::class,
        SettableUuidFieldInterface::PROP_SETTABLE_UUID                               => SettableUuidFakerData::class,
        UnicodeLanguageIdentifierFieldInterface::PROP_UNICODE_LANGUAGE_IDENTIFIER    => UnicodeLanguageIdentifierFakerData::class,
        UniqueStringFieldInterface::PROP_UNIQUE_STRING                               => UniqueStringFakerData::class,
        UrlFieldInterface::PROP_URL                                                  => UrlFakerData::class,
        DomainNameFieldInterface::PROP_DOMAIN_NAME                                   => DomainNameFakerData::class,
        ShortIndexedRequiredStringFieldInterface::PROP_SHORT_INDEXED_REQUIRED_STRING => ShortIndexedRequiredStringFakerData::class,
        IntegerWithinRangeFieldInterface::PROP_INTEGER_WITHIN_RANGE                  => IntegerWithinRangeFakerData::class,
        FloatWithinRangeFieldInterface::PROP_FLOAT_WITHIN_RANGE                      => FloatWithinRangeFakerData::class,
        IndexedUniqueIntegerFieldInterface::PROP_INDEXED_UNIQUE_INTEGER              => IndexedUniqueIntegerFakerData::class,
        BinaryUuidFieldInterface::PROP_BINARY_UUID                                   => BinaryUuidFakerData::class,
        UniqueEnumFieldInterface::PROP_UNIQUE_ENUM                                   => UniqueEnumFakerData::class,
    ];
    // phpcs:enable
}
