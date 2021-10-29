<?php

declare(strict_types=1);

namespace PoP\Engine\Hooks\ModuleFilters;

use PoP\ComponentModel\Facades\ModulePath\ModulePathHelpersFacade;
use PoP\ComponentModel\ModelInstance\ModelInstance;
use PoP\ComponentModel\ModuleFilters\ModulePaths;
use PoP\ComponentModel\ModulePath\ModulePathUtils;
use PoP\ComponentModel\State\ApplicationState;
use PoP\Hooks\AbstractHookSet;
use Symfony\Contracts\Service\Attribute\Required;

class ModulePathsHookSet extends AbstractHookSet
{
    protected ?ModulePaths $modulePaths = null;
    
    #[Required]
    final public function autowireModulePathsHookSet(
        ModulePaths $modulePaths
    ): void {
        $this->modulePaths = $modulePaths;
    }

    protected function init(): void
    {
        $this->hooksAPI->addFilter(
            ModelInstance::HOOK_COMPONENTSFROMVARS_RESULT,
            [$this, 'maybeAddComponent']
        );
        $this->hooksAPI->addAction(
            'ApplicationState:addVars',
            [$this, 'addVars'],
            10,
            1
        );
    }
    /**
     * @param array<array> $vars_in_array
     */
    public function addVars(array $vars_in_array): void
    {
        [&$vars] = $vars_in_array;
        if (isset($vars['modulefilter']) && $vars['modulefilter'] == $this->modulePaths->getName()) {
            $vars['modulepaths'] = ModulePathUtils::getModulePaths();
        }
    }
    public function maybeAddComponent(array $components): array
    {
        $vars = ApplicationState::getVars();
        if (isset($vars['modulefilter']) && $vars['modulefilter'] == $this->modulePaths->getName()) {
            if ($modulepaths = $vars['modulepaths']) {
                $modulePathHelpers = ModulePathHelpersFacade::getInstance();
                $paths = array_map(
                    fn ($modulepath) => $modulePathHelpers->stringifyModulePath($modulepath),
                    $modulepaths
                );
                $components[] = $this->translationAPI->__('module paths:', 'engine') . implode(',', $paths);
            }
        }

        return $components;
    }
}
