<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\ObjectFacades;

use GraphQLByPoP\GraphQLServer\ObjectModels\MutationRoot;
use PoP\Root\Container\ContainerBuilderFactory;

class MutationRootObjectFacade
{
    public static function getInstance(): MutationRoot
    {
        $containerBuilderFactory = \PoP\Engine\App::getContainerBuilderFactory()->getInstance();
        return $containerBuilderFactory->get(MutationRoot::class);
    }
}
