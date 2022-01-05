<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Facades\Cache;

use PoP\Root\App;
use PoP\ComponentModel\Cache\TransientCacheInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class TransientCacheManagerFacade
{
    public static function getInstance(): TransientCacheInterface
    {
        /**
         * @var TransientCacheInterface
         */
        $service = App::getContainerBuilderFactory()->getInstance()->get(TransientCacheInterface::class);
        return $service;
    }
}
