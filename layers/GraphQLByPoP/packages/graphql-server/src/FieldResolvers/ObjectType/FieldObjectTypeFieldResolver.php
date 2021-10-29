<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\FieldResolvers\ObjectType;

use GraphQLByPoP\GraphQLServer\ObjectModels\Field;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\FieldObjectTypeResolver;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\InputValueObjectTypeResolver;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\TypeObjectTypeResolver;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoPSchema\SchemaCommons\TypeResolvers\ScalarType\JSONObjectScalarTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class FieldObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    protected ?BooleanScalarTypeResolver $booleanScalarTypeResolver = null;
    protected ?StringScalarTypeResolver $stringScalarTypeResolver = null;
    protected ?JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver = null;
    protected ?InputValueObjectTypeResolver $inputValueObjectTypeResolver = null;
    protected ?TypeObjectTypeResolver $typeObjectTypeResolver = null;

    #[Required]
    final public function autowireFieldObjectTypeFieldResolver(
        BooleanScalarTypeResolver $booleanScalarTypeResolver,
        StringScalarTypeResolver $stringScalarTypeResolver,
        JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver,
        InputValueObjectTypeResolver $inputValueObjectTypeResolver,
        TypeObjectTypeResolver $typeObjectTypeResolver,
    ): void {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
        $this->jsonObjectScalarTypeResolver = $jsonObjectScalarTypeResolver;
        $this->inputValueObjectTypeResolver = $inputValueObjectTypeResolver;
        $this->typeObjectTypeResolver = $typeObjectTypeResolver;
    }

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            FieldObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'name',
            'description',
            'args',
            'type',
            'isDeprecated',
            'deprecationReason',
            'extensions',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'name' => $this->getStringScalarTypeResolver(),
            'description' => $this->getStringScalarTypeResolver(),
            'isDeprecated' => $this->getBooleanScalarTypeResolver(),
            'deprecationReason' => $this->getStringScalarTypeResolver(),
            'extensions' => $this->getJsonObjectScalarTypeResolver(),
            'args' => $this->getInputValueObjectTypeResolver(),
            'type' => $this->getTypeObjectTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'name',
            'type',
            'isDeprecated',
            'extensions'
                => SchemaTypeModifiers::NON_NULLABLE,
            'args'
                => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default
                => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'name' => $this->getTranslationAPI()->__('Field\'s name', 'graphql-server'),
            'description' => $this->getTranslationAPI()->__('Field\'s description', 'graphql-server'),
            'args' => $this->getTranslationAPI()->__('Field arguments', 'graphql-server'),
            'type' => $this->getTranslationAPI()->__('Type to which the field belongs', 'graphql-server'),
            'isDeprecated' => $this->getTranslationAPI()->__('Is the field deprecated?', 'graphql-server'),
            'deprecationReason' => $this->getTranslationAPI()->__('Why was the field deprecated?', 'graphql-server'),
            'extensions' => $this->getTranslationAPI()->__('Custom metadata added to the field (see: https://github.com/graphql/graphql-spec/issues/300#issuecomment-504734306 and below comments, and https://github.com/graphql/graphql-js/issues/1527)', 'graphql-server'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        /** @var Field */
        $field = $object;
        switch ($fieldName) {
            case 'name':
                return $field->getName();
            case 'description':
                return $field->getDescription();
            case 'args':
                return $field->getArgIDs();
            case 'type':
                return $field->getTypeID();
            case 'isDeprecated':
                return $field->isDeprecated();
            case 'deprecationReason':
                return $field->getDeprecationMessage();
            case 'extensions':
                return (object) $field->getExtensions();
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
