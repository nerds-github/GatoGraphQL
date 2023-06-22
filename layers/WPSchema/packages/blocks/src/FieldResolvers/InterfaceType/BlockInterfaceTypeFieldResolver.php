<?php

declare(strict_types=1);

namespace PoPWPSchema\Blocks\FieldResolvers\InterfaceType;

use PoPSchema\SchemaCommons\TypeResolvers\ScalarType\HTMLScalarTypeResolver;
use PoPWPSchema\Blocks\TypeHelpers\BlockUnionTypeHelpers;
use PoPWPSchema\Blocks\TypeResolvers\InterfaceType\BlockInterfaceTypeResolver;
use PoP\ComponentModel\FieldResolvers\InterfaceType\AbstractInterfaceTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InterfaceType\InterfaceTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\JSONObjectScalarTypeResolver;

class BlockInterfaceTypeFieldResolver extends AbstractInterfaceTypeFieldResolver
{
    private ?JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver = null;
    private ?StringScalarTypeResolver $stringScalarTypeResolver = null;
    private ?HTMLScalarTypeResolver $htmlScalarTypeResolver = null;

    final public function setJSONObjectScalarTypeResolver(JSONObjectScalarTypeResolver $jsonObjectScalarTypeResolver): void
    {
        $this->jsonObjectScalarTypeResolver = $jsonObjectScalarTypeResolver;
    }
    final protected function getJSONObjectScalarTypeResolver(): JSONObjectScalarTypeResolver
    {
        /** @var JSONObjectScalarTypeResolver */
        return $this->jsonObjectScalarTypeResolver ??= $this->instanceManager->getInstance(JSONObjectScalarTypeResolver::class);
    }
    final public function setStringScalarTypeResolver(StringScalarTypeResolver $stringScalarTypeResolver): void
    {
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }
    final protected function getStringScalarTypeResolver(): StringScalarTypeResolver
    {
        /** @var StringScalarTypeResolver */
        return $this->stringScalarTypeResolver ??= $this->instanceManager->getInstance(StringScalarTypeResolver::class);
    }
    final public function setHTMLScalarTypeResolver(HTMLScalarTypeResolver $htmlScalarTypeResolver): void
    {
        $this->htmlScalarTypeResolver = $htmlScalarTypeResolver;
    }
    final protected function getHTMLScalarTypeResolver(): HTMLScalarTypeResolver
    {
        /** @var HTMLScalarTypeResolver */
        return $this->htmlScalarTypeResolver ??= $this->instanceManager->getInstance(HTMLScalarTypeResolver::class);
    }

    /**
     * @return array<class-string<InterfaceTypeResolverInterface>>
     */
    public function getInterfaceTypeResolverClassesToAttachTo(): array
    {
        return [
            BlockInterfaceTypeResolver::class,
        ];
    }

    /**
     * @return string[]
     */
    public function getFieldNamesToImplement(): array
    {
        return [
            'name',
            'attributes',
            'innerBlocks',
            // 'innerHTML',
            'contentSource',
        ];
    }

    public function getFieldTypeResolver(string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'name' => $this->getStringScalarTypeResolver(),
            'attributes' => $this->getJSONObjectScalarTypeResolver(),
            'innerBlocks' => BlockUnionTypeHelpers::getBlockUnionOrTargetObjectTypeResolver(),
            // 'innerHTML' => $this->getHTMLScalarTypeResolver(),
            'contentSource' => $this->getHTMLScalarTypeResolver(),
            default => parent::getFieldTypeResolver($fieldName),
        };
    }

    public function getFieldTypeModifiers(string $fieldName): int
    {
        return match ($fieldName) {
            'name',
            // 'innerHTML',
            'contentSource'
                => SchemaTypeModifiers::NON_NULLABLE,
            'innerBlocks'
                => SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default
                => parent::getFieldTypeModifiers($fieldName),
        };
    }

    public function getFieldDescription(string $fieldName): ?string
    {
        return match ($fieldName) {
            'name' => $this->__('Block name', 'blocks'),
            'attributes' => $this->__('Block attributes, parsed to the type declared in their block.json schema', 'blocks'),
            'innerBlocks' => $this->__('Block\'s inner blocks (if suitable)', 'blocks'),
            // 'innerHTML' => $this->__('Block\'s inner HTML code', 'blocks'),
            'contentSource' => $this->__('Block\'s whole HTML code, including the block comment delimiters', 'blocks'),
            default => parent::getFieldDescription($fieldName),
        };
    }
}