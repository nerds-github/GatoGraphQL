<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\ComponentProcessors\ComponentProcessorManagerInterface;
use PoP\ComponentModel\ComponentProcessors\FormComponentComponentProcessorInterface;
use PoPSitesWassup\EverythingElseMutations\MutationResolverUtils\MutationResolverUtils;

trait CreateUpdateProfileMutationResolverBridgeTrait
{
    abstract protected function getComponentProcessorManager(): ComponentProcessorManagerInterface;

    protected function getUsercommunitiesFormData(\PoP\ComponentModel\Mutation\FieldDataProviderInterface $fieldDataProvider)
    {
        $inputs = MutationResolverUtils::getMyCommunityFormInputs();
        /** @var FormComponentComponentProcessorInterface */
        $componentProcessor = $this->getComponentProcessorManager()->getComponentProcessor($inputs['communities']);
        $communities = $componentProcessor->getValue($inputs['communities']);
        $fieldDataProvider->add('communities', $communities ?? array());
    }
}
