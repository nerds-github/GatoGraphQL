<?php

declare(strict_types=1);

namespace PoPSitesWassup\CustomPostLinkMutations;

use PoP\Root\Module\AbstractModule;

class Module extends AbstractModule
{
    /**
     * @return array<class-string<\PoP\Root\Module\ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \PoPSitesWassup\CustomPostMutations\Module::class,
        ];
    }
}
