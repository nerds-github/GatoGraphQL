<?php

declare(strict_types=1);

namespace PoPSchema\PostMutations\SchemaHooks;

use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\MutationRootObjectTypeResolver;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoPSchema\Posts\TypeResolvers\ObjectType\PostObjectTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

trait PostMutationResolverHookSetTrait
{
    protected ?RootObjectTypeResolver $rootObjectTypeResolver = null;
    protected ?MutationRootObjectTypeResolver $mutationRootObjectTypeResolver = null;
    protected ?PostObjectTypeResolver $postObjectTypeResolver = null;

    #[Required]
    public function autowirePostMutationResolverHookSetTrait(
        RootObjectTypeResolver $rootObjectTypeResolver,
        MutationRootObjectTypeResolver $mutationRootObjectTypeResolver,
        PostObjectTypeResolver $postObjectTypeResolver,
    ): void {
        $this->getRoot()ObjectTypeResolver = $rootObjectTypeResolver;
        $this->mutationRootObjectTypeResolver = $mutationRootObjectTypeResolver;
        $this->postObjectTypeResolver = $postObjectTypeResolver;
    }

    protected function mustAddFieldArgs(
        ObjectTypeResolverInterface $objectTypeResolver,
        string $fieldName,
    ): bool {
        $isRootMutationType =
            $objectTypeResolver === $this->getRoot()ObjectTypeResolver
            || $objectTypeResolver === $this->getMutationRootObjectTypeResolver();
        return
            ($isRootMutationType && $fieldName === 'createPost')
            || ($isRootMutationType && $fieldName === 'updatePost')
            || ($objectTypeResolver === $this->getPostObjectTypeResolver() && $fieldName === 'update');
    }
}
