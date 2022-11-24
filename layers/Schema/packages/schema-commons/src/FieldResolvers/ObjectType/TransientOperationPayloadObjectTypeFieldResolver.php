<?php

declare(strict_types=1);

namespace PoPSchema\SchemaCommons\FieldResolvers\ObjectType;

use PoPSchema\SchemaCommons\ObjectModels\AbstractTransientOperationPayload;
use PoPSchema\SchemaCommons\TypeResolvers\EnumType\OperationStatusEnumTypeResolver;
use PoPSchema\SchemaCommons\TypeResolvers\ObjectType\AbstractTransientOperationPayloadObjectTypeResolver;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;

class TransientOperationPayloadObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    private ?OperationStatusEnumTypeResolver $operationStatusEnumTypeResolver = null;

    final public function setOperationStatusEnumTypeResolver(OperationStatusEnumTypeResolver $operationStatusEnumTypeResolver): void
    {
        $this->operationStatusEnumTypeResolver = $operationStatusEnumTypeResolver;
    }
    final protected function getOperationStatusEnumTypeResolver(): OperationStatusEnumTypeResolver
    {
        /** @var OperationStatusEnumTypeResolver */
        return $this->operationStatusEnumTypeResolver ??= $this->instanceManager->getInstance(OperationStatusEnumTypeResolver::class);
    }

    /**
     * @return array<class-string<ObjectTypeResolverInterface>>
     */
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            AbstractTransientOperationPayloadObjectTypeResolver::class,
        ];
    }

    /**
     * @return string[]
     */
    public function getFieldNamesToResolve(): array
    {
        return [
            'status',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'status' => $this->getOperationStatusEnumTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'status' => SchemaTypeModifiers::NON_NULLABLE,
            default => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'status' => $this->__('Status of the operation', 'schema-commons'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): mixed {
        /** @var AbstractTransientOperationPayload */
        $objectTransientOperationPayload = $object;
        /**
         * The parent already resolves all remaining fields
         */
        return parent::resolveValue($objectTypeResolver, $object, $fieldDataAccessor, $objectTypeFieldResolutionFeedbackStore);
    }
}
