<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\WebserverRequests;

use PoP\Root\Module\AbstractModule;
use PoP\Root\Environment;

class Module extends AbstractModule
{
    /**
     * @return array<class-string<\PoP\Root\Module\ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \GraphQLByPoP\GraphQLServer\Module::class,
        ];
    }

    protected function resolveEnabled(): bool
    {
        return Environment::isApplicationEnvironmentDevPHPUnit();
    }
}
