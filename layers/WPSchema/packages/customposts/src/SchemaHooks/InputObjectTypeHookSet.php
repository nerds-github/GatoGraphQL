<?php

declare(strict_types=1);

namespace PoPWPSchema\CustomPosts\SchemaHooks;

use PoP\ComponentModel\TypeResolvers\InputObjectType\HookNames;
use PoP\ComponentModel\TypeResolvers\InputObjectType\InputObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\Engine\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoP\Hooks\AbstractHookSet;
use PoPSchema\CustomPosts\TypeResolvers\InputObjectType\AbstractCustomPostsFilterInputObjectTypeResolver;
use PoPWPSchema\CustomPosts\FilterInputProcessors\FilterInputProcessor;

class InputObjectTypeHookSet extends AbstractHookSet
{
    private ?BooleanScalarTypeResolver $booleanScalarTypeResolver = null;
    private ?StringScalarTypeResolver $stringScalarTypeResolver = null;

    final public function setBooleanScalarTypeResolver(BooleanScalarTypeResolver $booleanScalarTypeResolver): void
    {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }
    final protected function getBooleanScalarTypeResolver(): BooleanScalarTypeResolver
    {
        return $this->booleanScalarTypeResolver ??= $this->instanceManager->getInstance(BooleanScalarTypeResolver::class);
    }
    final public function setStringScalarTypeResolver(StringScalarTypeResolver $stringScalarTypeResolver): void
    {
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }
    final protected function getStringScalarTypeResolver(): StringScalarTypeResolver
    {
        return $this->stringScalarTypeResolver ??= $this->instanceManager->getInstance(StringScalarTypeResolver::class);
    }

    protected function init(): void
    {
        $this->getHooksAPI()->addFilter(
            HookNames::INPUT_FIELD_NAME_TYPE_RESOLVERS,
            [$this, 'getInputFieldNameTypeResolvers'],
            10,
            2
        );
        $this->getHooksAPI()->addFilter(
            HookNames::ADMIN_INPUT_FIELD_NAMES,
            [$this, 'getAdminInputFieldNames'],
            10,
            2
        );
        $this->getHooksAPI()->addFilter(
            HookNames::INPUT_FIELD_DESCRIPTION,
            [$this, 'getInputFieldDescription'],
            10,
            3
        );
        $this->getHooksAPI()->addFilter(
            HookNames::INPUT_FIELD_DEFAULT_VALUE,
            [$this, 'getInputFieldDefaultValue'],
            10,
            3
        );
        $this->getHooksAPI()->addFilter(
            HookNames::INPUT_FIELD_FILTER_INPUT,
            [$this, 'getInputFieldFilterInput'],
            10,
            3
        );
    }

    /**
     * @param array<string, InputTypeResolverInterface> $inputFieldNameTypeResolvers
     */
    public function getInputFieldNameTypeResolvers(
        array $inputFieldNameTypeResolvers,
        InputObjectTypeResolverInterface $inputObjectTypeResolver,
    ): array {
        if (!($inputObjectTypeResolver instanceof AbstractCustomPostsFilterInputObjectTypeResolver)) {
            return $inputFieldNameTypeResolvers;
        }
        return array_merge(
            $inputFieldNameTypeResolvers,
            [
                'hasPassword' => $this->getBooleanScalarTypeResolver(),
                'password' => $this->getStringScalarTypeResolver(),
            ]
        );
    }

    /**
     * @param string[] $inputFieldNames
     * @return string[]
     */
    public function getAdminInputFieldNames(
        array $inputFieldNames,
        InputObjectTypeResolverInterface $inputObjectTypeResolver,
    ): array {
        if (!($inputObjectTypeResolver instanceof AbstractCustomPostsFilterInputObjectTypeResolver)) {
            return $inputFieldNames;
        }
        return array_merge(
            $inputFieldNames,
            [
                'hasPassword',
                'password',
            ]
        );
    }

    public function getInputFieldDescription(
        ?string $inputFieldDescription,
        InputObjectTypeResolverInterface $inputObjectTypeResolver,
        string $inputFieldName
    ): ?string {
        if (!($inputObjectTypeResolver instanceof AbstractCustomPostsFilterInputObjectTypeResolver)) {
            return $inputFieldDescription;
        }
        return match ($inputFieldName) {
            'hasPassword' => $this->getTranslationAPI()->__('Indicate if to include custom posts which are password-protected. Pass `null` to fetch both with/out password', 'customposts'),
            'password' => $this->getTranslationAPI()->__('Include custom posts protected by a specific password', 'customposts'),
            default => $inputFieldDescription,
        };
    }

    public function getInputFieldDefaultValue(
        mixed $inputFieldDefaultValue,
        InputObjectTypeResolverInterface $inputObjectTypeResolver,
        string $inputFieldName
    ): mixed {
        if (!($inputObjectTypeResolver instanceof AbstractCustomPostsFilterInputObjectTypeResolver)) {
            return $inputFieldDefaultValue;
        }
        return match ($inputFieldName) {
            'hasPassword' => false,
            default => $inputFieldDefaultValue,
        };
    }

    public function getInputFieldFilterInput(
        ?array $inputFieldFilterInput,
        InputObjectTypeResolverInterface $inputObjectTypeResolver,
        string $inputFieldName,
    ): ?array {
        if (!($inputObjectTypeResolver instanceof AbstractCustomPostsFilterInputObjectTypeResolver)) {
            return $inputFieldFilterInput;
        }
        return match ($inputFieldName) {
            'hasPassword' => [FilterInputProcessor::class, FilterInputProcessor::FILTERINPUT_HAS_PASSWORD],
            'password' => [FilterInputProcessor::class, FilterInputProcessor::FILTERINPUT_PASSWORD],
            default => $inputFieldFilterInput,
        };
    }
}
