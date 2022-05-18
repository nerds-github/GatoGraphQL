<?php

declare(strict_types=1);

namespace PoP\Engine\Hooks\ComponentFilters;

use PoP\Root\App;
use PoP\ComponentModel\Facades\ModulePath\ModulePathHelpersFacade;
use PoP\ComponentModel\ModelInstance\ModelInstance;
use PoP\ComponentModel\ComponentFilters\ModulePaths;
use PoP\Root\Hooks\AbstractHookSet;

class ModulePathsHookSet extends AbstractHookSet
{
    private ?ModulePaths $componentPaths = null;
    
    final public function setModulePaths(ModulePaths $componentPaths): void
    {
        $this->componentPaths = $componentPaths;
    }
    final protected function getModulePaths(): ModulePaths
    {
        return $this->componentPaths ??= $this->instanceManager->getInstance(ModulePaths::class);
    }

    protected function init(): void
    {
        App::addFilter(
            ModelInstance::HOOK_COMPONENTSFROMVARS_RESULT,
            $this->maybeAddComponent(...)
        );
    }
    
    public function maybeAddComponent(array $components): array
    {
        if (App::getState('modulefilter') === $this->componentPaths->getName()) {
            if ($componentPaths = App::getState('componentPaths')) {
                $modulePathHelpers = ModulePathHelpersFacade::getInstance();
                $paths = array_map(
                    fn ($componentPath) => $modulePathHelpers->stringifyModulePath($componentPath),
                    $componentPaths
                );
                $components[] = $this->getTranslationAPI()->__('module paths:', 'engine') . implode(',', $paths);
            }
        }

        return $components;
    }
}
