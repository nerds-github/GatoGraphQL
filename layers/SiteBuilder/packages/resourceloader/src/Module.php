<?php

declare(strict_types=1);

namespace PoP\ResourceLoader;

use PoP\Root\Module\AbstractModule;

class Module extends AbstractModule
{
    /**
     * @return array<class-string<\PoP\Root\Module\ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \PoP\Resources\Module::class,
        ];
    }
}
