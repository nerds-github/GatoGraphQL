<?php

declare(strict_types=1);

namespace PoPSchema\Highlights;

use PoP\Root\Module\AbstractModule;

class Module extends AbstractModule
{
    /**
     * @return array<class-string<\PoP\Root\Module\ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \PoPCMSSchema\CustomPosts\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param array<string,mixed> $configuration
     * @param array<class-string<\PoP\Root\Module\ModuleInterface>> $skipSchemaModuleClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaModuleClasses,
    ): void {
        $this->initSchemaServices(dirname(__DIR__), $skipSchema);
        if (Environment::addHighlightTypeToCustomPostUnionTypes()) {
            $this->initSchemaServices(dirname(__DIR__), $skipSchema, '/ConditionalOnContext/AddHighlightTypeToCustomPostUnionTypes');
        }
    }
}
