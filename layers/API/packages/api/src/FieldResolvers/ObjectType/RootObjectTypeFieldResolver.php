<?php

declare(strict_types=1);

namespace PoP\API\FieldResolvers\ObjectType;

use PoP\API\PersistedQueries\PersistedFragmentManagerInterface;
use PoP\API\PersistedQueries\PersistedQueryManagerInterface;
use PoP\API\Schema\SchemaDefinitionServiceInterface;
use PoP\API\TypeResolvers\EnumType\SchemaFieldShapeEnumTypeResolver;
use PoP\ComponentModel\Cache\PersistentCacheInterface;
use PoP\ComponentModel\Facades\Cache\PersistentCacheFacade;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaDefinitionShapes;
use PoP\ComponentModel\Schema\SchemaDefinitionTypes;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoPSchema\SchemaCommons\TypeResolvers\ScalarType\ObjectScalarTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class RootObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    /**
     * Cannot autowire because its calling `getNamespace`
     * on services.yaml produces an exception of PHP properties not initialized
     * in its depended services.
     */
    protected ?PersistentCacheInterface $persistentCache = null;

    protected SchemaFieldShapeEnumTypeResolver $schemaOutputShapeEnumTypeResolver;
    protected ObjectScalarTypeResolver $objectScalarTypeResolver;
    protected PersistedFragmentManagerInterface $fragmentCatalogueManager;
    protected PersistedQueryManagerInterface $queryCatalogueManager;
    protected BooleanScalarTypeResolver $booleanScalarTypeResolver;

    #[Required]
    final public function autowireRootObjectTypeFieldResolver(
        SchemaFieldShapeEnumTypeResolver $schemaOutputShapeEnumTypeResolver,
        ObjectScalarTypeResolver $objectScalarTypeResolver,
        PersistedFragmentManagerInterface $fragmentCatalogueManager,
        PersistedQueryManagerInterface $queryCatalogueManager,
        BooleanScalarTypeResolver $booleanScalarTypeResolver,
    ): void {
        $this->schemaOutputShapeEnumTypeResolver = $schemaOutputShapeEnumTypeResolver;
        $this->objectScalarTypeResolver = $objectScalarTypeResolver;
        $this->fragmentCatalogueManager = $fragmentCatalogueManager;
        $this->queryCatalogueManager = $queryCatalogueManager;
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }

    final public function getPersistentCache(): PersistentCacheInterface
    {
        $this->persistentCache ??= PersistentCacheFacade::getInstance();
        return $this->persistentCache;
    }

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'fullSchema',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'fullSchema' => $this->objectScalarTypeResolver,
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'fullSchema' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'fullSchema' => $this->translationAPI->__('The whole API schema, exposing what fields can be queried', 'api'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgNameTypeResolvers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        return match ($fieldName) {
            'fullSchema' => [
                'deep' => $this->booleanScalarTypeResolver,
                'shape' => $this->schemaOutputShapeEnumTypeResolver,
                'compressed' => $this->booleanScalarTypeResolver,
                'useTypeName' => $this->booleanScalarTypeResolver,
            ],
            default => parent::getFieldArgNameTypeResolvers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): ?string
    {
        return match ([$fieldName => $fieldArgName]) {
            ['fullSchema' => 'deep'] => $this->translationAPI->__('Make a deep introspection of the fields, for all nested objects', 'api'),
            ['fullSchema' => 'shape'] => sprintf(
                $this->translationAPI->__('How to shape the schema output: \'%s\', in which case all types are listed together, or \'%s\', in which the types are listed following where they appear in the graph', 'api'),
                SchemaDefinitionShapes::FLAT,
                SchemaDefinitionShapes::NESTED
            ),
            ['fullSchema' => 'compressed'] => $this->translationAPI->__('Output each resolver\'s schema data only once to compress the output. Valid only when field \'deep\' is `true`', 'api'),
            ['fullSchema' => 'useTypeName'] => sprintf(
                $this->translationAPI->__('Replace type \'%s\' with the actual type name (such as \'Post\')', 'api'),
                SchemaDefinitionTypes::TYPE_ID
            ),
            default => parent::getFieldArgDescription($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function getFieldArgDefaultValue(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): mixed
    {
        return match ([$fieldName => $fieldArgName]) {
            ['fullSchema' => 'deep'] => true,
            ['fullSchema' => 'shape'] => SchemaDefinitionShapes::FLAT,
            ['fullSchema' => 'compressed'] => false,
            ['fullSchema' => 'useTypeName'] => true,
            default => parent::getFieldArgDefaultValue($objectTypeResolver, $fieldName, $fieldArgName),
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
        $root = $object;
        switch ($fieldName) {
            case 'fullSchema':
                /** @var SchemaDefinitionServiceInterface */
                $schemaDefinitionService = $this->schemaDefinitionService;
                return $schemaDefinitionService->getFullSchemaDefinition();
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}
