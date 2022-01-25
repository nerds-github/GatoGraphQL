<?php
use PoP\Root\App;
use PoPCMSSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;

class PoPTheme_Wassup_AE_SpecialSinglePost extends PoP_UserPreferences_SimpleProcessorAutomatedEmailsBase
{
    public function getRoute()
    {
        return POP_COMMONAUTOMATEDEMAILS_ROUTE_SINGLEPOST_SPECIAL;
    }

    protected function getPreferenceonUsersValue()
    {
        return POP_USERPREFERENCES_EMAILDIGESTS_SPECIALPOSTS;
    }

    protected function getSubject()
    {
        $postID = App::query(\PoPCMSSchema\Posts\Constants\InputNames::POST_ID);
        if ($postID !== null) {
            // The post id is passed through param pid
            $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
            return $customPostTypeAPI->getTitle($postID);
        }
        return '';
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_AE_SpecialSinglePost();
