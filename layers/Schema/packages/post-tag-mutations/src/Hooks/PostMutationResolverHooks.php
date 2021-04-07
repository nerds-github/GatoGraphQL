<?php

declare(strict_types=1);

namespace PoPSchema\PostTagMutations\Hooks;

use PoPSchema\CustomPostTagMutations\Hooks\AbstractCustomPostMutationResolverHooks;
use PoPSchema\CustomPostTagMutations\TypeAPIs\CustomPostTagTypeMutationAPIInterface;
use PoPSchema\Posts\Facades\PostTypeAPIFacade;
use PoPSchema\Posts\TypeResolvers\PostTypeResolver;
use PoPSchema\PostTagMutations\Facades\PostTagTypeMutationAPIFacade;

class PostMutationResolverHooks extends AbstractCustomPostMutationResolverHooks
{
    protected function getTypeResolverClass(): string
    {
        return PostTypeResolver::class;
    }

    protected function getCustomPostType(): string
    {
        $postTypeAPI = PostTypeAPIFacade::getInstance();
        return $postTypeAPI->getPostCustomPostType();
    }

    protected function getCustomPostTagTypeMutationAPI(): CustomPostTagTypeMutationAPIInterface
    {
        return PostTagTypeMutationAPIFacade::getInstance();
    }
}
