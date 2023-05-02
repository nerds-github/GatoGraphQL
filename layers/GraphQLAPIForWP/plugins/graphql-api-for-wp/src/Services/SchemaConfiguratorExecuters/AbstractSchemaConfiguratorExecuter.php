<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\SchemaConfiguratorExecuters;

use GraphQLAPI\GraphQLAPI\App;
use GraphQLAPI\GraphQLAPI\AppHelpers;
use GraphQLAPI\GraphQLAPI\Module;
use GraphQLAPI\GraphQLAPI\ModuleConfiguration;
use GraphQLAPI\GraphQLAPI\Services\SchemaConfigurators\SchemaConfiguratorInterface;
use PoP\Root\Module\ApplicationEvents;
use PoP\Root\Services\AbstractAutomaticallyInstantiatedService;
use PoP\Root\Services\BasicServiceTrait;

abstract class AbstractSchemaConfiguratorExecuter extends AbstractAutomaticallyInstantiatedService
{
    use BasicServiceTrait;

    /**
     * Execute before all the services are attached,
     * as to use this configuration to affect these.
     *
     * For instance, the Queryable Custom Post Types can be
     * configured in the Schema Configuration, and from this list
     * will the ObjectTypeResolverPicker for the GenericCustomPost
     * decide if to add it to the CustomPostUnion or not. Hence,
     * this service must be executed before the Attachable services
     * are executed.
     */
    public function getInstantiationEvent(): string
    {
        return ApplicationEvents::PRE_BOOT;
    }

    public function isServiceEnabled(): bool
    {
        /**
         * Maybe do not initialize for the Internal AppThread
         *
         * @var ModuleConfiguration
         */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        if (
            !$moduleConfiguration->useSchemaConfigurationInInternalGraphQLServer()
            && AppHelpers::isInternalGraphQLServerAppThread()
        ) {
            return false;
        }

        return true;
    }

    /**
     * Initialize the configuration if a certain condition is satisfied
     */
    public function initialize(): void
    {
        $schemaConfigurator = $this->getSchemaConfigurator();
        $schemaConfigurationID = $this->getSchemaConfigurationID();
        if ($schemaConfigurationID === null) {
            $schemaConfigurator->executeNoneAppliedSchemaConfiguration();
            return;
        }
        $schemaConfigurator->executeSchemaConfiguration($schemaConfigurationID);
    }

    /**
     * Provide the ID of the custom post containing the Schema Configuration block
     */
    abstract protected function getSchemaConfigurationID(): ?int;

    /**
     * Initialize the configuration of services before the execution of the GraphQL query
     */
    abstract protected function getSchemaConfigurator(): SchemaConfiguratorInterface;
}
