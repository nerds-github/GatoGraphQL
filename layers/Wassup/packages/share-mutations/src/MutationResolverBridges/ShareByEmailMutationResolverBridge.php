<?php

declare(strict_types=1);

namespace PoPSitesWassup\ShareMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\ShareMutations\MutationResolvers\ShareByEmailMutationResolver;
use PoPSitesWassup\FormMutations\MutationResolverBridges\AbstractFormComponentMutationResolverBridge;

class ShareByEmailMutationResolverBridge extends AbstractFormComponentMutationResolverBridge
{
    public function __construct(
        \PoP\Hooks\HooksAPIInterface $hooksAPI,
        \PoP\Translation\TranslationAPIInterface $translationAPI,
        \PoP\ComponentModel\Instances\InstanceManagerInterface $instanceManager,
        \PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface $mutationResolutionManager,
        protected ShareByEmailMutationResolver $shareByEmailMutationResolver,
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
        return $this->shareByEmailMutationResolver;
    }

    public function getFormData(): array
    {
        $form_data = array(
            'name' => $this->moduleProcessorManager->getProcessor([\PoP_Forms_Module_Processor_TextFormInputs::class, \PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME])->getValue([\PoP_Forms_Module_Processor_TextFormInputs::class, \PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME]),
            'email' => $this->moduleProcessorManager->getProcessor([\PoP_Share_Module_Processor_TextFormInputs::class, \PoP_Share_Module_Processor_TextFormInputs::MODULE_FORMINPUT_DESTINATIONEMAIL])->getValue([\PoP_Share_Module_Processor_TextFormInputs::class, \PoP_Share_Module_Processor_TextFormInputs::MODULE_FORMINPUT_DESTINATIONEMAIL]),
            'message' => $this->moduleProcessorManager->getProcessor([\PoP_Module_Processor_TextareaFormInputs::class, \PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_ADDITIONALMESSAGE])->getValue([\PoP_Module_Processor_TextareaFormInputs::class, \PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_ADDITIONALMESSAGE]),
            'target-url' => $this->moduleProcessorManager->getProcessor([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETURL])->getValue([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETURL]),
            'target-title' => $this->moduleProcessorManager->getProcessor([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETTITLE])->getValue([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETTITLE]),
        );

        return $form_data;
    }
}
