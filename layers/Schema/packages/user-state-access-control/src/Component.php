<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl;

use PoP\Engine\App;
use PoP\Root\Managers\ComponentManager;
use PoP\AccessControl\Component as AccessControlComponent;
use PoP\CacheControl\Component as CacheControlComponent;
use PoP\BasicService\Component\AbstractComponent;
use PoP\Root\Component\CanDisableComponentTrait;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    use CanDisableComponentTrait;

    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public function getDependedComponentClasses(): array
    {
        return [
            \PoPSchema\UserState\Component::class,
            \PoP\AccessControl\Component::class,
        ];
    }

    /**
     * All conditional component classes that this component depends upon, to initialize them
     */
    public function getDependedConditionalComponentClasses(): array
    {
        return [
            \PoP\CacheControl\Component::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param string[] $skipSchemaComponentClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void {
        if ($this->isEnabled()) {
            $this->initServices(dirname(__DIR__));
            $this->initSchemaServices(dirname(__DIR__), $skipSchema);

            // Init conditional on API package being installed
            if (class_exists(CacheControlComponent::class)) {
                $this->initSchemaServices(
                    dirname(__DIR__),
                    $skipSchema || in_array(\PoP\CacheControl\Component::class, $skipSchemaComponentClasses),
                    '/ConditionalOnComponent/CacheControl'
                );
            }
        }
    }

    protected function resolveEnabled(): bool
    {
        return App::getComponentManager()->getComponent(AccessControlComponent::class)->isEnabled();
    }
}
