<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\CreateUpdateOrganizationProfileMutationResolver;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\CreateUpdateProfileMutationResolver;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\CreateUpdateWithCommunityOrganizationProfileMutationResolver;

class CreateUpdateWithCommunityOrganizationProfileMutationResolverBridge extends CreateUpdateOrganizationProfileMutationResolverBridge
{
    public function __construct(
        \PoP\Hooks\HooksAPIInterface $hooksAPI,
        \PoP\Translation\TranslationAPIInterface $translationAPI,
        \PoP\ComponentModel\Instances\InstanceManagerInterface $instanceManager,
        \PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface $mutationResolutionManager,
        CreateUpdateProfileMutationResolver $createUpdateProfileMutationResolver,
        CreateUpdateOrganizationProfileMutationResolver $createUpdateOrganizationProfileMutationResolver,
        protected CreateUpdateWithCommunityOrganizationProfileMutationResolver $createUpdateWithCommunityOrganizationProfileMutationResolver,
    ) {
        parent::__construct(
            $hooksAPI,
            $translationAPI,
            $instanceManager,
            $mutationResolutionManager,
            $createUpdateProfileMutationResolver,
            $createUpdateOrganizationProfileMutationResolver,
        );
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->createUpdateWithCommunityOrganizationProfileMutationResolver;
    }

    private function getFormInputs()
    {
        return array_merge(
            $this->getCommonuserrolesFormInputs(),
            $this->getProfileorganizationFormInputs()
        );
    }
    protected function getProfileorganizationFormInputs()
    {
        $inputs = $this->hooksAPI->applyFilters(
            'GD_CommonUserRole_UserCommunities_CreateUpdate_ProfileOrganization:form-inputs',
            array(
                'is_community' => null,
            )
        );

        // If any input is null, throw an exception
        $null_inputs = array_filter($inputs, 'is_null');
        if ($null_inputs) {
            throw new Exception(
                sprintf(
                    'No form inputs defined for: %s',
                    '"' . implode('", "', array_keys($null_inputs)) . '"'
                )
            );
        }

        return $inputs;
    }

    public function getFormData(): array
    {
        $inputs = $this->getFormInputs();
        return array_merge(
            parent::getFormData(),
            $this->getCommonuserrolesFormData(),
            array(
                'is_community' => (bool)$this->moduleProcessorManager->getProcessor($inputs['is_community'])->getValue($inputs['is_community']),
            )
        );
    }
}
