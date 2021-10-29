<?php

declare(strict_types=1);

namespace PoPSitesWassup\PostLinkMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\PostLinkMutations\MutationResolvers\UpdatePostLinkMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class UpdatePostLinkMutationResolverBridge extends AbstractCreateUpdatePostLinkMutationResolverBridge
{
    protected ?UpdatePostLinkMutationResolver $updatePostLinkMutationResolver = null;

    #[Required]
    final public function autowireUpdatePostLinkMutationResolverBridge(
        UpdatePostLinkMutationResolver $updatePostLinkMutationResolver,
    ): void {
        $this->updatePostLinkMutationResolver = $updatePostLinkMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUpdatePostLinkMutationResolver();
    }

    protected function isUpdate(): bool
    {
        return true;
    }
}
