<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\RecommendCustomPostMutationResolver;

class RecommendCustomPostMutationResolverBridge extends AbstractCustomPostUpdateUserMetaValueMutationResolverBridge
{
    public function __construct(
        HooksAPIInterface $hooksAPI,
        TranslationAPIInterface $translationAPI,
        InstanceManagerInterface $instanceManager,
        MutationResolutionManagerInterface $mutationResolutionManager,
        protected RecommendCustomPostMutationResolver $recommendCustomPostMutationResolver,
    ) {
        parent::__construct(
            $hooksAPI,
            $translationAPI,
            $instanceManager,
            $mutationResolutionManager,
        );
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->recommendCustomPostMutationResolver;
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return sprintf(
            $this->translationAPI->__('You have recommended <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $customPostTypeAPI->getTitle($result_id)
        );
    }
}
