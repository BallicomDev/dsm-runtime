<?php

declare(strict_types=1);

namespace LTS\DsmRuntime;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use InvalidArgumentException;

use function ucfirst;

/**
 * This is used to pull out various methods from the doctrine meta data. It is based on the assumption that the methods
 * follow the ${methodType}${$propertyName} convention, with add methods using the singular version of the property
 */
class RelationshipHelper
{
    public const PREFIX_OWNING         = 'Owning';
    public const PREFIX_INVERSE        = 'Inverse';
    public const PREFIX_UNIDIRECTIONAL = 'Unidirectional';
    public const PREFIX_REQUIRED       = 'Required';


    /*******************************************************************************************************************
     * OneToOne - One instance of the current Entity refers to One instance of the referred Entity.
     */
    public const INTERNAL_TYPE_ONE_TO_ONE = 'OneToOne';

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntity/HasTemplateEntityOwningOneToOne.php
     */
    public const HAS_ONE_TO_ONE = self::PREFIX_OWNING . self::INTERNAL_TYPE_ONE_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntity/HasRequiredTemplateEntityOwningOneToOne.php
     */
    public const HAS_REQUIRED_ONE_TO_ONE = self::PREFIX_REQUIRED . self::PREFIX_OWNING . self::INTERNAL_TYPE_ONE_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntity/HasTemplateEntityInverseOneToOne.php
     */
    public const HAS_INVERSE_ONE_TO_ONE = self::PREFIX_INVERSE . self::INTERNAL_TYPE_ONE_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntity/HasRequiredTemplateEntityInverseOneToOne.php
     */
    public const HAS_REQUIRED_INVERSE_ONE_TO_ONE = self::PREFIX_REQUIRED .
                                                   self::PREFIX_INVERSE .
                                                   self::INTERNAL_TYPE_ONE_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntity/HasTemplateEntityUnidrectionalOneToOne.php
     */
    public const HAS_UNIDIRECTIONAL_ONE_TO_ONE = self::PREFIX_UNIDIRECTIONAL . self::INTERNAL_TYPE_ONE_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntity/HasRequiredTemplateEntityUnidrectionalOneToOne.php
     */
    public const HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_ONE = self::PREFIX_REQUIRED .
                                                          self::PREFIX_UNIDIRECTIONAL .
                                                          self::INTERNAL_TYPE_ONE_TO_ONE;

    /*******************************************************************************************************************
     * OneToMany - One instance of the current Entity has Many instances (references) to the referred Entity.
     */
    public const INTERNAL_TYPE_ONE_TO_MANY = 'OneToMany';

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntities/HasTemplateEntitiesOneToMany.php
     */
    public const HAS_ONE_TO_MANY = self::INTERNAL_TYPE_ONE_TO_MANY;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntities/HasRequiredTemplateEntitiesOneToMany.php
     */
    public const HAS_REQUIRED_ONE_TO_MANY = self::PREFIX_REQUIRED . self::INTERNAL_TYPE_ONE_TO_MANY;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntities/HasTemplateEntitiesOneToMany.php
     */
    public const HAS_UNIDIRECTIONAL_ONE_TO_MANY = self::PREFIX_UNIDIRECTIONAL . self::INTERNAL_TYPE_ONE_TO_MANY;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntities/HasRequiredTemplateEntitiesOneToMany.php
     */
    public const HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_MANY = self::PREFIX_REQUIRED .
                                                           self::PREFIX_UNIDIRECTIONAL .
                                                           self::INTERNAL_TYPE_ONE_TO_MANY;

    /*******************************************************************************************************************
     * ManyToOne - Many instances of the current Entity refer to One instance of the referred Entity.
     */
    public const INTERNAL_TYPE_MANY_TO_ONE = 'ManyToOne';

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntity/HasTemplateEntityManyToOne.php
     */
    public const HAS_MANY_TO_ONE = self::INTERNAL_TYPE_MANY_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntity/HasRequiredTemplateEntityManyToOne.php
     */
    public const HAS_REQUIRED_MANY_TO_ONE = self::PREFIX_REQUIRED . self::INTERNAL_TYPE_MANY_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntity/HasTemplateEntityManyToOne.php
     */
    public const HAS_UNIDIRECTIONAL_MANY_TO_ONE = self::PREFIX_UNIDIRECTIONAL . self::INTERNAL_TYPE_MANY_TO_ONE;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntity/HasRequiredTemplateEntityManyToOne.php
     */
    public const HAS_REQUIRED_UNIDIRECTIONAL_MANY_TO_ONE = self::PREFIX_REQUIRED .
                                                           self::PREFIX_UNIDIRECTIONAL .
                                                           self::INTERNAL_TYPE_MANY_TO_ONE;


    /*******************************************************************************************************************
     * ManyToMany - Many instances of the current Entity refer to Many instance of the referred Entity.
     */
    public const INTERNAL_TYPE_MANY_TO_MANY = 'ManyToMany';

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntities/HasTemplateEntitiesOwningManyToMany.php
     */
    public const HAS_MANY_TO_MANY = self::PREFIX_OWNING . self::INTERNAL_TYPE_MANY_TO_MANY;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntities/HasRequiredTemplateEntitiesOwningManyToMany.php
     */
    public const HAS_REQUIRED_MANY_TO_MANY = self::PREFIX_REQUIRED .
                                             self::PREFIX_OWNING .
                                             self::INTERNAL_TYPE_MANY_TO_MANY;
    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasTemplateEntities/HasTemplateEntitiesInverseManyToMany.php
     */
    public const HAS_INVERSE_MANY_TO_MANY = self::PREFIX_INVERSE . self::INTERNAL_TYPE_MANY_TO_MANY;

    /**
     * @see codeTemplates/src/Entities/Traits/Relations/TemplateEntity/HasRequiredTemplateEntities/HasRequiredTemplateEntitiesInverseManyToMany.php
     */
    public const HAS_REQUIRED_INVERSE_MANY_TO_MANY = self::PREFIX_REQUIRED .
                                                     self::PREFIX_INVERSE .
                                                     self::INTERNAL_TYPE_MANY_TO_MANY;


    /**
     * The full list of possible relation types
     */
    public const HAS_TYPES = [
        self::HAS_ONE_TO_ONE,
        self::HAS_INVERSE_ONE_TO_ONE,
        self::HAS_UNIDIRECTIONAL_ONE_TO_ONE,
        self::HAS_ONE_TO_MANY,
        self::HAS_UNIDIRECTIONAL_ONE_TO_MANY,
        self::HAS_MANY_TO_ONE,
        self::HAS_UNIDIRECTIONAL_MANY_TO_ONE,
        self::HAS_MANY_TO_MANY,
        self::HAS_INVERSE_MANY_TO_MANY,

        self::HAS_REQUIRED_ONE_TO_ONE,
        self::HAS_REQUIRED_INVERSE_ONE_TO_ONE,
        self::HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_ONE,
        self::HAS_REQUIRED_ONE_TO_MANY,
        self::HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_MANY,
        self::HAS_REQUIRED_MANY_TO_ONE,
        self::HAS_REQUIRED_UNIDIRECTIONAL_MANY_TO_ONE,
        self::HAS_REQUIRED_MANY_TO_MANY,
        self::HAS_REQUIRED_INVERSE_MANY_TO_MANY,
    ];

    /**
     * Of the full list, which ones will be automatically reciprocated in the generated code
     */
    public const HAS_TYPES_RECIPROCATED = [
        self::HAS_ONE_TO_ONE,
        self::HAS_INVERSE_ONE_TO_ONE,
        self::HAS_ONE_TO_MANY,
        self::HAS_MANY_TO_ONE,
        self::HAS_MANY_TO_MANY,
        self::HAS_INVERSE_MANY_TO_MANY,

        self::HAS_REQUIRED_ONE_TO_ONE,
        self::HAS_REQUIRED_INVERSE_ONE_TO_ONE,
        self::HAS_REQUIRED_ONE_TO_MANY,
        self::HAS_REQUIRED_MANY_TO_ONE,
        self::HAS_REQUIRED_MANY_TO_MANY,
        self::HAS_REQUIRED_INVERSE_MANY_TO_MANY,
    ];

    /**
     *Of the full list, which ones are unidirectional (i.e not reciprocated)
     */
    public const HAS_TYPES_UNIDIRECTIONAL = [
        self::HAS_UNIDIRECTIONAL_MANY_TO_ONE,
        self::HAS_UNIDIRECTIONAL_ONE_TO_MANY,
        self::HAS_UNIDIRECTIONAL_ONE_TO_ONE,

        self::HAS_REQUIRED_UNIDIRECTIONAL_MANY_TO_ONE,
        self::HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_MANY,
        self::HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_ONE,
    ];

    /**
     * Of the full list, which ones are a plural relationship, i.e they have multiple of the related entity
     */
    public const HAS_TYPES_PLURAL = [
        self::HAS_MANY_TO_MANY,
        self::HAS_INVERSE_MANY_TO_MANY,
        self::HAS_ONE_TO_MANY,
        self::HAS_UNIDIRECTIONAL_ONE_TO_MANY,

        self::HAS_REQUIRED_MANY_TO_MANY,
        self::HAS_REQUIRED_INVERSE_MANY_TO_MANY,
        self::HAS_REQUIRED_ONE_TO_MANY,
        self::HAS_REQUIRED_UNIDIRECTIONAL_ONE_TO_MANY,
    ];


    /**
     * Use this to get the getter for the property, can be used with all relations
     *
     * @param array $mapping
     *
     * @return string
     */
    public function getGetterFromDoctrineMapping(array $mapping): string
    {
        $this->assertMappingLevel($mapping);
        $property = $this->getUppercaseProperty($mapping);

        return "get${property}";
    }

    /**
     * Use this to get the setter for the property, can be used with all relations
     *
     * @param array $mapping
     *
     * @return string
     */
    public function getSetterFromDoctrineMapping(array $mapping): string
    {
        $this->assertMappingLevel($mapping);
        $property = $this->getUppercaseProperty($mapping);

        return "set${property}";
    }

    /**
     * Use this to get the adder for the property, can only be used with *_TO_MANY relations
     *
     * @param array $mapping
     *
     * @return string
     */
    public function getAdderFromDoctrineMapping(array $mapping): string
    {
        $this->assertMappingLevel($mapping);
        $property = $this->getUppercaseProperty($mapping);
        if ($this->isPlural($mapping) === false) {
            throw new InvalidArgumentException("$property is singular, so doesn't have an add method");
        }

        return 'add' . MappingHelper::singularize($property);
    }

    /**
     * User this to get the remover for the property, can only be used with *_TO_MANY relations
     *
     * @param array $mapping
     *
     * @return string
     */
    public function getRemoverFromDoctrineMapping(array $mapping): string
    {
        $this->assertMappingLevel($mapping);
        $property = $this->getUppercaseProperty($mapping);
        if ($this->isPlural($mapping) === false) {
            throw new InvalidArgumentException("$property is singular, so doesn't have an add method");
        }

        return 'remove' . MappingHelper::singularize($property);
    }

    /**
     * Use this to check if the relationship is plural (*_TO_MANY) or singular (*_TO_ONE)
     *
     * @param array $mapping
     *
     * @return bool
     */
    public function isPlural(array $mapping): bool
    {
        $this->assertMappingLevel($mapping);
        $type = $mapping['type'];
        switch ($type) {
            case ClassMetadataInfo::ONE_TO_ONE:
            case ClassMetadataInfo::MANY_TO_ONE:
                return false;
            case ClassMetadataInfo::ONE_TO_MANY:
            case ClassMetadataInfo::MANY_TO_MANY:
                return true;
        }

        throw new InvalidArgumentException("Unknown relationship of $type");
    }

    public function getFieldName(array $mapping): string
    {
        $this->assertMappingLevel($mapping);

        return $mapping['fieldName'];
    }

    private function getUppercaseProperty(array $mapping): string
    {
        return ucfirst($this->getFieldName($mapping));
    }

    private function assertMappingLevel(array $mapping): void
    {
        if (!isset($mapping['type'])) {
            throw new InvalidArgumentException('Could not find the type key, are you using the correct mapping array');
        }
    }
}
