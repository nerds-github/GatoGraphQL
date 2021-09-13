<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostsWP\Overrides\TypeResolvers\UnionType;

use PoPSchema\CustomPosts\TypeResolvers\UnionType\CustomPostUnionTypeResolver as UpstreamCustomPostUnionTypeResolver;

class CustomPostUnionTypeResolver extends UpstreamCustomPostUnionTypeResolver
{
    /**
     * Overriding function to provide optimization:
     * instead of calling ->isIDOfType on each object (as in parent function),
     * in which case we must make a DB call for each result,
     * we obtain all the types from executing a single query against the DB
     */
    public function getObjectIDTargetTypeResolvers(array $ids): array
    {
        $objectIDTargetTypeResolvers = [];
        $customPostUnionTypeDataLoader = $this->instanceManager->getInstance($this->getRelationalTypeDataLoaderClass());
        // If any ID cannot be resolved, the object will be null
        if ($customPosts = array_filter($customPostUnionTypeDataLoader->getObjects($ids))) {
            foreach ($customPosts as $customPost) {
                $targetObjectTypeResolver = $this->getTargetObjectTypeResolver($customPost);
                if ($targetObjectTypeResolver !== null) {
                    $objectIDTargetTypeResolvers[$targetObjectTypeResolver->getID($customPost)] = $targetObjectTypeResolver;
                }
            }
        }
        return $objectIDTargetTypeResolvers;
    }
}
