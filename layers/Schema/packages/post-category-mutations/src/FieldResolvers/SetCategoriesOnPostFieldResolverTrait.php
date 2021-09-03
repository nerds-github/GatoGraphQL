<?php

declare(strict_types=1);

namespace PoPSchema\PostCategoryMutations\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSchema\PostCategories\TypeResolvers\Object\PostCategoryTypeResolver;
use PoPSchema\PostCategoryMutations\MutationResolvers\SetCategoriesOnPostMutationResolver;
use PoPSchema\Posts\TypeResolvers\Object\PostTypeResolver;

trait SetCategoriesOnPostFieldResolverTrait
{
    protected function getCustomPostTypeResolverClass(): string
    {
        return PostTypeResolver::class;
    }

    protected function getTypeMutationResolverClass(): string
    {
        return SetCategoriesOnPostMutationResolver::class;
    }

    protected function getCategoryTypeResolverClass(): string
    {
        return PostCategoryTypeResolver::class;
    }

    protected function getEntityName(): string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('post', 'post-category-mutations');
    }
}
