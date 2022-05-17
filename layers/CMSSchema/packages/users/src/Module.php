<?php

declare(strict_types=1);

namespace PoPCMSSchema\Users;

use PoP\Root\App;
use PoPAPI\API\Module as APIModule;
use PoPAPI\RESTAPI\Module as RESTAPIModule;
use PoP\Root\Module\AbstractModule;
use PoPCMSSchema\CustomPosts\Module as CustomPostsModule;

/**
 * Initialize component
 */
class Module extends AbstractModule
{
    protected function requiresSatisfyingComponent(): bool
    {
        return true;
    }

    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public function getDependedComponentClasses(): array
    {
        return [
            \PoPCMSSchema\QueriedObject\Module::class,
        ];
    }

    /**
     * All conditional component classes that this component depends upon, to initialize them
     */
    public function getDependedConditionalComponentClasses(): array
    {
        return [
            \PoPAPI\API\Module::class,
            \PoPAPI\RESTAPI\Module::class,
            \PoPCMSSchema\CustomPosts\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param string[] $skipSchemaComponentClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaComponentClasses,
    ): void {
        $this->initServices(dirname(__DIR__));
        $this->initSchemaServices(dirname(__DIR__), $skipSchema);

        if (class_exists(APIModule::class) && App::getComponent(APIModule::class)->isEnabled()) {
            $this->initServices(dirname(__DIR__), '/ConditionalOnModule/API');
        }
        if (class_exists(RESTAPIModule::class) && App::getComponent(RESTAPIModule::class)->isEnabled()) {
            $this->initServices(dirname(__DIR__), '/ConditionalOnModule/RESTAPI');
        }

        if (class_exists(CustomPostsModule::class)) {
            $this->initServices(dirname(__DIR__), '/ConditionalOnModule/CustomPosts');
            $this->initSchemaServices(
                dirname(__DIR__),
                $skipSchema || in_array(\PoPCMSSchema\CustomPosts\Module::class, $skipSchemaComponentClasses),
                '/ConditionalOnModule/CustomPosts'
            );
            if (class_exists(APIModule::class) && App::getComponent(APIModule::class)->isEnabled()) {
                $this->initServices(dirname(__DIR__), '/ConditionalOnModule/CustomPosts/ConditionalOnModule/API');
            }
            if (class_exists(RESTAPIModule::class) && App::getComponent(RESTAPIModule::class)->isEnabled()) {
                $this->initServices(dirname(__DIR__), '/ConditionalOnModule/CustomPosts/ConditionalOnModule/RESTAPI');
            }
        }
    }
}
