<?php

declare(strict_types=1);

namespace PoPCMSSchema\SettingsWP;

use PoP\Root\Module\AbstractModule;

class Module extends AbstractModule
{
    /**
     * @return array<class-string<\PoPCMSSchema\Settings\Module>>
     */
    public function getSatisfiedModuleClasses(): array
    {
        return [
            \PoPCMSSchema\Settings\Module::class,
        ];
    }
    /**
     * @return array<class-string<\PoP\Root\Module\ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \PoPCMSSchema\Settings\Module::class,
            \PoPCMSSchema\SchemaCommonsWP\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param array<class-string<\PoP\Root\Module\ModuleInterface>> $skipSchemaModuleClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaModuleClasses,
    ): void {
        $this->initServices(dirname(__DIR__));
    }
}
