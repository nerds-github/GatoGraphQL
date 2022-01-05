<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Facades\DirectivePipeline;

use PoP\Root\App;
use PoP\ComponentModel\DirectivePipeline\DirectivePipelineServiceInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class DirectivePipelineServiceFacade
{
    public static function getInstance(): DirectivePipelineServiceInterface
    {
        /**
         * @var DirectivePipelineServiceInterface
         */
        $service = App::getContainerBuilderFactory()->getInstance()->get(DirectivePipelineServiceInterface::class);
        return $service;
    }
}
