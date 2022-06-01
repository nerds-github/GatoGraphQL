<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ModelInstance;

use PoP\Root\App;
use PoP\ComponentModel\Info\ApplicationInfoInterface;
use PoP\Root\Services\BasicServiceTrait;
use PoP\Definitions\DefinitionManagerInterface;

class ModelInstance implements ModelInstanceInterface
{
    use BasicServiceTrait;

    public final const HOOK_COMPONENTS_RESULT = __CLASS__ . ':elements:result';
    public final const HOOK_COMPONENTSFROMVARS_POSTORGETCHANGE = __CLASS__ . ':elementsFromVars:postOrGetChange';
    public final const HOOK_COMPONENTSFROMVARS_RESULT = __CLASS__ . ':elementsFromVars:result';

    private ?ApplicationInfoInterface $applicationInfo = null;
    private ?DefinitionManagerInterface $definitionManager = null;

    final public function setApplicationInfo(ApplicationInfoInterface $applicationInfo): void
    {
        $this->applicationInfo = $applicationInfo;
    }
    final protected function getApplicationInfo(): ApplicationInfoInterface
    {
        return $this->applicationInfo ??= $this->instanceManager->getInstance(ApplicationInfoInterface::class);
    }
    final public function setDefinitionManager(DefinitionManagerInterface $definitionManager): void
    {
        $this->definitionManager = $definitionManager;
    }
    final protected function getDefinitionManager(): DefinitionManagerInterface
    {
        return $this->definitionManager ??= $this->instanceManager->getInstance(DefinitionManagerInterface::class);
    }

    public function getModelInstanceId(): string
    {
        // The string is too long. Use a hashing function to shorten it
        return md5(implode('-', $this->getModelInstanceComponents()));
    }

    /**
     * @return string[]
     */
    protected function getModelInstanceComponents(): array
    {
        $elements = array();

        // Mix the information specific to the module, with that present in the application state
        $elements = (array)App::applyFilters(
            self::HOOK_COMPONENTS_RESULT,
            array_merge(
                $elements,
                $this->getModelInstanceComponentsFromAppState()
            )
        );

        // Add the ones from package Definitions

        // Comment Leo 05/04/2017: Also add the component-definition type, for 2 reasons:
        // 1. It allows to create the 2 versions (DEV/PROD) of the configuration files, to compare/debug them side by side
        // 2. It allows to switch from DEV/PROD without having to delete the pop-cache
        if ($definitionResolvers = $this->getDefinitionManager()->getDefinitionResolvers()) {
            $resolvers = [];
            foreach ($definitionResolvers as $group => $resolverInstance) {
                $resolvers[] = $group . '-' . get_class($resolverInstance);
            }
            $elements[] = $this->__('definition resolvers:', 'component-model') . implode(',', $resolvers);
        }

        return $elements;
    }

    /**
     * @return string[]
     */
    protected function getModelInstanceComponentsFromAppState(): array
    {
        $elements = array();

        // There will always be a nature. Add it.
        $nature = App::getState('nature');
        $route = App::getState('route');
        $elements[] = $this->__('nature:', 'component-model') . $nature;
        $elements[] = $this->__('route:', 'component-model') . $route;

        // Add the version, because otherwise there may be PHP errors happening from stale configuration that is not deleted, and still served, after a new version is deployed
        $elements[] = $this->__('version:', 'component-model') . $this->getApplicationInfo()->getVersion();

        // Other properties
        if ($actions = App::getState('actions')) {
            $elements[] = $this->__('actions:', 'component-model') . implode(';', $actions);
        }
        if ($componentFilter = App::getState('componentFilter')) {
            $elements[] = $this->__('component filter:', 'component-model') . $componentFilter;
        }

        // Can the configuration change when doing a POST or GET?
        if (
            App::applyFilters(
                self::HOOK_COMPONENTSFROMVARS_POSTORGETCHANGE,
                false
            )
        ) {
            $elements[] = $this->__('operation:', 'component-model') . ('POST' === App::server('REQUEST_METHOD') ? 'post' : 'get');
        }
        if ($mangled = App::getState('mangled')) {
            // By default it is mangled. To make it non-mangled, url must have param "mangled=none",
            // so only in these exceptional cases the identifier will add this parameter
            $elements[] = $this->__('mangled:', 'component-model') . $mangled;
        }
        if (App::getState('only-fieldname-as-outputkey')) {
            $elements[] = $this->__('only-fieldname-as-outputkey', 'component-model');
        }
        if ($versionConstraint = App::getState('version-constraint')) {
            $elements[] = $this->__('version-constraint:', 'component-model') . $versionConstraint;
        }
        if ($fieldVersionConstraints = App::getState('field-version-constraints')) {
            $elements[] = $this->__('field-version-constraints:', 'component-model') . json_encode($fieldVersionConstraints);
        }
        if ($directiveVersionConstraints = App::getState('directive-version-constraints')) {
            $elements[] = $this->__('directive-version-constraints:', 'component-model') . json_encode($directiveVersionConstraints);
        }

        // Allow for plug-ins to add their own vars. Eg: URE source parameter
        return (array)App::applyFilters(
            self::HOOK_COMPONENTSFROMVARS_RESULT,
            $elements
        );
    }
}
