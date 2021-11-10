<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\TypeResolvers\InputObjectType;

use PoP\Engine\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoPSchema\CustomPosts\TypeResolvers\InputObjectType\CustomPostDateQueryInputObjectTypeResolver;
use PoPSchema\SchemaCommons\TypeResolvers\InputObjectType\AbstractObjectsFilterInputObjectTypeResolver;

abstract class AbstractCustomPostsFilterInputObjectTypeResolver extends AbstractObjectsFilterInputObjectTypeResolver
{
    private ?CustomPostDateQueryInputObjectTypeResolver $customPostDateQueryInputObjectTypeResolver = null;

    final public function setCustomPostDateQueryInputObjectTypeResolver(CustomPostDateQueryInputObjectTypeResolver $customPostDateQueryInputObjectTypeResolver): void
    {
        $this->customPostDateQueryInputObjectTypeResolver = $customPostDateQueryInputObjectTypeResolver;
    }
    final protected function getCustomPostDateQueryInputObjectTypeResolver(): CustomPostDateQueryInputObjectTypeResolver
    {
        return $this->customPostDateQueryInputObjectTypeResolver ??= $this->instanceManager->getInstance(CustomPostDateQueryInputObjectTypeResolver::class);
    }

    public function getInputFieldNameTypeResolvers(): array
    {
        return array_merge(
            parent::getInputFieldNameTypeResolvers(),
            [
                'search' => $this->getStringScalarTypeResolver(),
                'dateQuery' => $this->getCustomPostDateQueryInputObjectTypeResolver(),
            ]
        );
    }

    public function getInputFieldDescription(string $inputFieldName): ?string
    {
        return match ($inputFieldName) {
            'search' => $this->getTranslationAPI()->__('Search for elements containing the given string', 'schema-commons'),
            'dateQuery' => $this->getTranslationAPI()->__('Filter elements based on date', 'schema-commons'),
            default => parent::getInputFieldDescription($inputFieldName),
        };
    }
}
