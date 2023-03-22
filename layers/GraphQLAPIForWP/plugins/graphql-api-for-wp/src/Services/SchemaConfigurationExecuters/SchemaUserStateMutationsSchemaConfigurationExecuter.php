<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\SchemaConfigurationExecuters;

class SchemaUserStateMutationsSchemaConfigurationExecuter extends AbstractSchemaMutationsSchemaConfigurationExecuter
{
    public function getHookModuleClass(): string
    {
        return \PoPCMSSchema\UserStateMutations\Module::class;
    }

    public function getHookEnvironmentClass(): string
    {
        return \PoPCMSSchema\UserStateMutations\Environment::USE_PAYLOADABLE_USERSTATE_MUTATIONS;
    }
}
