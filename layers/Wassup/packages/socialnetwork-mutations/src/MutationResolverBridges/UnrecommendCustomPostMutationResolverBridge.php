<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\UnrecommendCustomPostMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class UnrecommendCustomPostMutationResolverBridge extends AbstractCustomPostUpdateUserMetaValueMutationResolverBridge
{
    protected ?UnrecommendCustomPostMutationResolver $unrecommendCustomPostMutationResolver = null;

    #[Required]
    final public function autowireUnrecommendCustomPostMutationResolverBridge(
        UnrecommendCustomPostMutationResolver $unrecommendCustomPostMutationResolver,
    ): void {
        $this->unrecommendCustomPostMutationResolver = $unrecommendCustomPostMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUnrecommendCustomPostMutationResolver();
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        return sprintf(
            $this->getTranslationAPI()->__('You have stopped recommending <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $this->getCustomPostTypeAPI()->getTitle($result_id)
        );
    }
}
