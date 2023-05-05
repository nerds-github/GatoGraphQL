<?php

declare(strict_types=1);

namespace PoP\PoP\Config\Rector\Downgrade\Configurators\ChainedRules;

use PoP\PoP\Config\Rector\Downgrade\Configurators\GatoGraphQLContainerConfigurationServiceTrait;

class GatoGraphQLArrowFnMixedTypeChainedRuleContainerConfigurationService extends AbstractPluginArrowFnMixedTypeChainedRuleContainerConfigurationService
{
    use GatoGraphQLContainerConfigurationServiceTrait;

    protected function getPaths(): array
    {
        return [
            $this->pluginDir . '/vendor/getpop/component-model/src/TypeResolvers/AbstractRelationalTypeResolver.php',
            $this->pluginDir . '/vendor/getpop/component-model/src/TypeResolvers/ObjectType/AbstractObjectTypeResolver.php',
        ];
    }
}
