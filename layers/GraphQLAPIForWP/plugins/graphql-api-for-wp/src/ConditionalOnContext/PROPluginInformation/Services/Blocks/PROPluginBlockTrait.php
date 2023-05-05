<?php

declare(strict_types=1);

namespace GatoGraphQL\GatoGraphQL\ConditionalOnContext\PROPluginInformation\Services\Blocks;

use GatoGraphQL\GatoGraphQL\Services\Scripts\MainPluginScriptTrait;

/**
 * Trait to set common functions for a Gutenberg block for this plugin (GraphQL API)
 */
trait PROPluginBlockTrait
{
    use MainPluginScriptTrait;

    protected function getBlockNamespace(): string
    {
        return 'graphql-api-pro';
    }
}
