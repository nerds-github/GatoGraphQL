<?php

declare(strict_types=1);

namespace PoP\Root\Facades\Instances;

use PoP\Root\App;
use PoP\Root\Instances\InstanceManagerInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class InstanceManagerFacade
{
    public static function getInstance(): InstanceManagerInterface
    {
        /**
         * @var InstanceManagerInterface
         */
        $service = App::getContainerBuilderFactory()->getInstance()->get(InstanceManagerInterface::class);
        return $service;
    }
}
