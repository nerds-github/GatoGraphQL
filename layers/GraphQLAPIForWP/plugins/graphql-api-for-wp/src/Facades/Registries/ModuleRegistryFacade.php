<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Facades\Registries;

use PoP\Engine\App;
use GraphQLAPI\GraphQLAPI\Registries\ModuleRegistryInterface;
use PoP\Root\Container\ContainerBuilderFactory;

/**
 * Obtain an instance of the ModuleRegistry.
 */
class ModuleRegistryFacade
{
    public static function getInstance(): ModuleRegistryInterface
    {
        /**
         * @var ModuleRegistryInterface
         */
        return App::getContainerBuilderFactory()->getInstance()->get(ModuleRegistryInterface::class);
    }
}
