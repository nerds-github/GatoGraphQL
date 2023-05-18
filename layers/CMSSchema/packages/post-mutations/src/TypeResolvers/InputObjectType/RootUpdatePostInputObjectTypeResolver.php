<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostMutations\TypeResolvers\InputObjectType;

use PoPCMSSchema\CustomPostMutations\TypeResolvers\InputObjectType\AbstractCustomPostContentAsOneofInputObjectTypeResolver;
use PoPCMSSchema\CustomPostMutations\TypeResolvers\InputObjectType\RootUpdateCustomPostInputObjectTypeResolver;

class RootUpdatePostInputObjectTypeResolver extends RootUpdateCustomPostInputObjectTypeResolver implements UpdatePostInputObjectTypeResolverInterface
{
    private ?PostContentAsOneofInputObjectTypeResolver $postContentAsOneofInputObjectTypeResolver = null;

    final public function setPostContentAsOneofInputObjectTypeResolver(PostContentAsOneofInputObjectTypeResolver $postContentAsOneofInputObjectTypeResolver): void
    {
        $this->postContentAsOneofInputObjectTypeResolver = $postContentAsOneofInputObjectTypeResolver;
    }
    final protected function getPostContentAsOneofInputObjectTypeResolver(): PostContentAsOneofInputObjectTypeResolver
    {
        /** @var PostContentAsOneofInputObjectTypeResolver */
        return $this->postContentAsOneofInputObjectTypeResolver ??= $this->instanceManager->getInstance(PostContentAsOneofInputObjectTypeResolver::class);
    }

    public function getTypeName(): string
    {
        return 'RootUpdatePostInput';
    }

    protected function getContentAsOneofInputObjectTypeResolver(): AbstractCustomPostContentAsOneofInputObjectTypeResolver
    {
        return $this->getPostContentAsOneofInputObjectTypeResolver();
    }
}