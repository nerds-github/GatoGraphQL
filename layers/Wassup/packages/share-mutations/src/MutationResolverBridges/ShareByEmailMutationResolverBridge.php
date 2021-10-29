<?php

declare(strict_types=1);

namespace PoPSitesWassup\ShareMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\FormMutations\MutationResolverBridges\AbstractFormComponentMutationResolverBridge;
use PoPSitesWassup\ShareMutations\MutationResolvers\ShareByEmailMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class ShareByEmailMutationResolverBridge extends AbstractFormComponentMutationResolverBridge
{
    protected ?ShareByEmailMutationResolver $shareByEmailMutationResolver = null;

    #[Required]
    final public function autowireShareByEmailMutationResolverBridge(
        ShareByEmailMutationResolver $shareByEmailMutationResolver,
    ): void {
        $this->shareByEmailMutationResolver = $shareByEmailMutationResolver;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getShareByEmailMutationResolver();
    }

    public function getFormData(): array
    {
        $form_data = array(
            'name' => $this->getModuleProcessorManager()->getProcessor([\PoP_Forms_Module_Processor_TextFormInputs::class, \PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME])->getValue([\PoP_Forms_Module_Processor_TextFormInputs::class, \PoP_Forms_Module_Processor_TextFormInputs::MODULE_FORMINPUT_NAME]),
            'email' => $this->getModuleProcessorManager()->getProcessor([\PoP_Share_Module_Processor_TextFormInputs::class, \PoP_Share_Module_Processor_TextFormInputs::MODULE_FORMINPUT_DESTINATIONEMAIL])->getValue([\PoP_Share_Module_Processor_TextFormInputs::class, \PoP_Share_Module_Processor_TextFormInputs::MODULE_FORMINPUT_DESTINATIONEMAIL]),
            'message' => $this->getModuleProcessorManager()->getProcessor([\PoP_Module_Processor_TextareaFormInputs::class, \PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_ADDITIONALMESSAGE])->getValue([\PoP_Module_Processor_TextareaFormInputs::class, \PoP_Module_Processor_TextareaFormInputs::MODULE_FORMINPUT_ADDITIONALMESSAGE]),
            'target-url' => $this->getModuleProcessorManager()->getProcessor([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETURL])->getValue([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETURL]),
            'target-title' => $this->getModuleProcessorManager()->getProcessor([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETTITLE])->getValue([\PoP_Module_Processor_TextFormInputs::class, \PoP_Module_Processor_TextFormInputs::MODULE_FORMINPUT_TARGETTITLE]),
        );

        return $form_data;
    }
}
