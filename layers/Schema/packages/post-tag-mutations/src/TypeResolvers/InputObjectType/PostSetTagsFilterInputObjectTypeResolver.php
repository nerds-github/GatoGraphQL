<?php

declare(strict_types=1);

namespace PoPSchema\PostTagMutations\TypeResolvers\InputObjectType;

class PostSetTagsFilterInputObjectTypeResolver extends AbstractSetTagsOnPostFilterInputObjectTypeResolver
{
    public function getTypeName(): string
    {
        return 'PostSetTagsFilterInput';
    }

    protected function addCustomPostInputField(): bool
    {
        return false;
    }
}
