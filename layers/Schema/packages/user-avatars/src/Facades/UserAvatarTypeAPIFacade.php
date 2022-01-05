<?php

declare(strict_types=1);

namespace PoPSchema\UserAvatars\Facades;

use PoP\Engine\App;
use PoP\Root\Container\ContainerBuilderFactory;
use PoPSchema\UserAvatars\TypeAPIs\UserAvatarTypeAPIInterface;

class UserAvatarTypeAPIFacade
{
    public static function getInstance(): UserAvatarTypeAPIInterface
    {
        /**
         * @var UserAvatarTypeAPIInterface
         */
        $service = App::getContainerBuilderFactory()->getInstance()->get(UserAvatarTypeAPIInterface::class);
        return $service;
    }
}
