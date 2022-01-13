<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Root\Facades\Hooks\HooksAPIFacade;
use PoP\Root\Facades\Translation\TranslationAPIFacade;

// Execute after callable function has been defined in poptheme-wassup
HooksAPIFacade::getInstance()->addAction(
    'plugins_loaded',
    function () {
        HooksAPIFacade::getInstance()->addFilter('UserStance_Module_Processor_CustomCarouselControls:authorstances:titlelink', 'gdUreAddSourceParamPagesections');
    },
    1501
);

HooksAPIFacade::getInstance()->addFilter('UserStance_Module_Processor_CustomCarouselControls:authorstances:title', 'gdUserstanceUreTitlemembers');
function gdUserstanceUreTitlemembers($title)
{
    $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
    if (gdUreIsCommunity($author)) {
        if (\PoP\Root\App::getState('source') == GD_URLPARAM_URECONTENTSOURCE_COMMUNITY) {
            $title .= TranslationAPIFacade::getInstance()->__(' + Members', 'pop-userstance-processors');
        }
    }

    return $title;
}
