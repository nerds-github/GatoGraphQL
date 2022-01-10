<?php
use PoP\ComponentModel\State\ApplicationState;
use PoP\Hooks\Facades\HooksAPIFacade;

function getSocialloginProvider($user_id = null)
{
    if (is_null($user_id)) {
        $vars = ApplicationState::getVars();
        $user_id = \PoP\Root\App::getState('current-user-id');
    }

    $api = PoP_SocialLogin_APIFactory::getInstance();
    return $api->getProvider($user_id);
}

function isSocialloginUser($user_id = null)
{
    $provider = getSocialloginProvider($user_id);
    return $provider != null;
}

function getSocialloginNetworklinks()
{
    $api = PoP_SocialLogin_APIFactory::getInstance();
    return $api->getNetworklinks();
}

// Change the user's display name
HooksAPIFacade::getInstance()->addAction(
    'popcomponent:sociallogin:usercreated', 
    'userNameUpdated', 
    1
);
