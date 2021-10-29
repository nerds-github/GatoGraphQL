<?php

declare(strict_types=1);

namespace PoPSitesWassup\HighlightMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\HighlightMutations\MutationResolvers\CreateHighlightMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class CreateHighlightMutationResolverBridge extends AbstractCreateUpdateHighlightMutationResolverBridge
{
    protected ?CreateHighlightMutationResolver $createHighlightMutationResolver = null;

    #[Required]
    final public function autowireCreateHighlightMutationResolverBridge(
        CreateHighlightMutationResolver $createHighlightMutationResolver,
    ): void {
        $this->createHighlightMutationResolver = $createHighlightMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getCreateHighlightMutationResolver();
    }

    protected function isUpdate(): bool
    {
        return false;
    }
}
