<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks;

use GraphQLAPI\GraphQLAPI\Constants\BlockAttributeNames;
use GraphQLAPI\GraphQLAPI\PluginEnvironment;
use PoPSchema\SchemaCommons\Constants\Behaviors;

abstract class AbstractSchemaConfigSchemaAllowAccessToEntriesBlock extends AbstractSchemaConfigCustomizableConfigurationBlock
{
    /**
     * Pass localized data to the block
     *
     * @return array<string,mixed>
     */
    protected function getLocalizedData(): array
    {
        return array_merge(
            parent::getLocalizedData(),
            [
                'defaultBehavior' => $this->getDefaultBehavior(),
            ]
        );
    }

    protected function getDefaultBehavior(): string
    {
        return PluginEnvironment::areUnsafeDefaultsEnabled()
            ? Behaviors::DENY
            : Behaviors::ALLOW;
    }

    /**
     * @param array<string,mixed> $attributes
     */
    protected function doRenderBlock(array $attributes, string $content): string
    {
        $placeholder = '<p><strong>%s</strong></p>%s';
        $entries = $attributes[BlockAttributeNames::ENTRIES] ?? [];
        $behavior = $attributes[BlockAttributeNames::BEHAVIOR] ?? $this->getDefaultBehavior();
        return sprintf(
            $placeholder,
            $this->getRenderBlockLabel(),
            $entries ?
                sprintf(
                    '<ul><li><code>%s</code></li></ul>',
                    implode('</code></li><li><code>', $entries)
                ) :
                sprintf(
                    '<p><em>%s</em></p>',
                    \__('(not set)', 'graphql-api')
                )
        ) . sprintf(
            $placeholder,
            $this->__('Behavior', 'graphql-api'),
            match ($behavior) {
                Behaviors::ALLOW => sprintf('✅ %s', $this->__('Allow access', 'graphql-api')),
                Behaviors::DENY => sprintf('❌ %s', $this->__('Deny access', 'graphql-api')),
                default => $behavior,
            }
        );
    }

    abstract protected function getRenderBlockLabel(): string;
}
