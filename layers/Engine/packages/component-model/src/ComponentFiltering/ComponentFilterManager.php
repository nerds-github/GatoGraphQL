<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ComponentFiltering;

use PoP\ComponentModel\Configuration\Request;
use PoP\ComponentModel\ComponentFilters\ComponentFilterInterface;
use PoP\ComponentModel\ModulePath\ModulePathHelpersInterface;
use PoP\ComponentModel\ModulePath\ModulePathManagerInterface;
use PoP\Root\App;
use PoP\Root\Module as RootModule;
use PoP\Root\ModuleConfiguration as RootModuleConfiguration;
use PoP\Root\Services\BasicServiceTrait;

class ComponentFilterManager implements ComponentFilterManagerInterface
{
    use BasicServiceTrait;

    protected ?string $selected_filter_name = null;
    private ?ComponentFilterInterface $selected_filter = null;
    /**
     * @var array<string, ComponentFilterInterface>
     */
    protected array $componentfilters = [];
    protected bool $initialized = false;
    /**
     * From the moment in which a component variation is not excluded, every component variation from then on must also be included
     */
    protected ?string $not_excluded_ancestor_componentVariation = null;
    /**
     * @var array<array>|null
     */
    protected ?array $not_excluded_componentVariation_sets = null;
    /**
     * @var string[]|null
     */
    protected ?array $not_excluded_componentVariation_sets_as_string;
    /**
     * When targeting component variations in pop-engine.php (eg: when doing ->get_dbobjectids())
     * those component variations are already and always included, so no need to check
     * for their ancestors or anything
     */
    protected bool $neverExclude = false;

    private ?ModulePathManagerInterface $modulePathManager = null;
    private ?ModulePathHelpersInterface $modulePathHelpers = null;

    final public function setModulePathManager(ModulePathManagerInterface $modulePathManager): void
    {
        $this->modulePathManager = $modulePathManager;
    }
    final protected function getModulePathManager(): ModulePathManagerInterface
    {
        return $this->modulePathManager ??= $this->instanceManager->getInstance(ModulePathManagerInterface::class);
    }
    final public function setModulePathHelpers(ModulePathHelpersInterface $modulePathHelpers): void
    {
        $this->modulePathHelpers = $modulePathHelpers;
    }
    final protected function getModulePathHelpers(): ModulePathHelpersInterface
    {
        return $this->modulePathHelpers ??= $this->instanceManager->getInstance(ModulePathHelpersInterface::class);
    }

    public function addComponentFilter(ComponentFilterInterface $moduleFilter): void
    {
        $this->componentfilters[$moduleFilter->getName()] = $moduleFilter;
    }

    protected function init(): void
    {
        // Lazy initialize so that we can inject all the moduleFilters before checking the selected one
        $this->selected_filter_name = $this->selected_filter_name ?? $this->getSelectedComponentFilterName();
        if ($this->selected_filter_name) {
            $this->selected_filter = $this->componentfilters[$this->selected_filter_name];

            // Initialize only if we are intending to filter components. This way, passing componentfilter=somewrongpath will return an empty array, meaning to not render anything
            $this->not_excluded_componentVariation_sets = $this->not_excluded_componentVariation_sets_as_string = array();
        }
        $this->initialized = true;
    }

    /**
     * The selected filter can be set from outside by the engine
     */
    public function setSelectedComponentFilterName(string $selectedComponentFilterName): void
    {
        $this->selected_filter_name = $selectedComponentFilterName;
    }

    public function getSelectedComponentFilterName(): ?string
    {
        if ($this->selected_filter_name) {
            return $this->selected_filter_name;
        }
        /** @var RootModuleConfiguration */
        $rootModuleConfiguration = App::getModule(RootModule::class)->getConfiguration();
        if (!$rootModuleConfiguration->enablePassingStateViaRequest()) {
            return null;
        }

        // Only valid if there's a corresponding componentFilter
        $selectedComponentFilterName = Request::getComponentFilter();
        if ($selectedComponentFilterName !== null && in_array($selectedComponentFilterName, array_keys($this->componentfilters))) {
            return $selectedComponentFilterName;
        }

        return null;
    }

    public function getNotExcludedComponentVariationSets(): ?array
    {
        // It shall be used for requestmeta.rendermodules, to know from which modules the client must start rendering
        return $this->not_excluded_componentVariation_sets;
    }

    public function neverExclude($neverExclude): void
    {
        $this->neverExclude = $neverExclude;
    }

    public function excludeModule(array $componentVariation, array &$props): bool
    {
        if (!$this->initialized) {
            $this->init();
        }
        if ($this->selected_filter_name) {
            if ($this->neverExclude) {
                return false;
            }
            if (!is_null($this->not_excluded_ancestor_componentVariation)) {
                return false;
            }

            return $this->selected_filter->excludeModule($componentVariation, $props);
        }

        return false;
    }

    public function removeExcludedSubmodules(array $componentVariation, array $submodules): array
    {
        if (!$this->initialized) {
            $this->init();
        }
        if ($this->selected_filter_name) {
            if ($this->neverExclude) {
                return $submodules;
            }

            return $this->selected_filter->removeExcludedSubmodules($componentVariation, $submodules);
        }

        return $submodules;
    }

    /**
     * The `prepare` function advances the modulepath one level down, when interating into the submodules, and then calling `restore` the value goes one level up again
     */
    public function prepareForPropagation(array $componentVariation, array &$props): void
    {
        if (!$this->initialized) {
            $this->init();
        }
        if ($this->selected_filter_name) {
            if (!$this->neverExclude && is_null($this->not_excluded_ancestor_componentVariation) && $this->excludeModule($componentVariation, $props) === false) {
                // Set the current module as the one which is not excluded.
                $module_propagation_current_path = $this->getModulePathManager()->getPropagationCurrentPath();
                $module_propagation_current_path[] = $componentVariation;

                $this->not_excluded_ancestor_componentVariation = $this->getModulePathHelpers()->stringifyModulePath($module_propagation_current_path);

                // Add it to the list of not-excluded modules
                if (!in_array($this->not_excluded_ancestor_componentVariation, $this->not_excluded_componentVariation_sets_as_string)) {
                    $this->not_excluded_componentVariation_sets_as_string[] = $this->not_excluded_ancestor_componentVariation;
                    $this->not_excluded_componentVariation_sets[] = $module_propagation_current_path;
                }
            }

            $this->selected_filter->prepareForPropagation($componentVariation, $props);
        }

        // Add the module to the path
        $this->getModulePathManager()->prepareForPropagation($componentVariation, $props);
    }
    public function restoreFromPropagation(array $componentVariation, array &$props): void
    {
        if (!$this->initialized) {
            $this->init();
        }

        // Remove the module from the path
        $this->getModulePathManager()->restoreFromPropagation($componentVariation, $props);

        if ($this->selected_filter_name) {
            if (!$this->neverExclude && !is_null($this->not_excluded_ancestor_componentVariation) && $this->excludeModule($componentVariation, $props) === false) {
                $module_propagation_current_path = $this->getModulePathManager()->getPropagationCurrentPath();
                $module_propagation_current_path[] = $componentVariation;

                // If the current module was set as the one not excluded, then reset it
                if ($this->not_excluded_ancestor_componentVariation == $this->getModulePathHelpers()->stringifyModulePath($module_propagation_current_path)) {
                    $this->not_excluded_ancestor_componentVariation = null;
                }
            }

            $this->selected_filter->restoreFromPropagation($componentVariation, $props);
        }
    }
}
