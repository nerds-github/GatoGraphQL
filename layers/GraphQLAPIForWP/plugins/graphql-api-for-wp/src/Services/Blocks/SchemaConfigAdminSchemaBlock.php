<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks;

use GraphQLAPI\GraphQLAPI\ComponentConfiguration;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\SchemaTypeModuleResolver;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\AbstractBlockCategory;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\SchemaConfigurationBlockCategory;
use GraphQLAPI\GraphQLAPI\Services\Blocks\MainPluginBlockTrait;

class SchemaConfigAdminSchemaBlock extends AbstractOptionsBlock implements SchemaConfigBlockServiceTagInterface
{
    use MainPluginBlockTrait;

    public const ATTRIBUTE_NAME_ENABLE_ADMIN_SCHEMA = 'enableAdminSchema';

    public const ATTRIBUTE_VALUE_ENABLED = 'enabled';
    public const ATTRIBUTE_VALUE_DISABLED = 'disabled';

    protected function getBlockName(): string
    {
        return 'schema-config-admin-schema';
    }

    public function getSchemaConfigBlockPriority(): int
    {
        return 40;
    }

    protected function getBlockCategory(): ?AbstractBlockCategory
    {
        /**
         * @var SchemaConfigurationBlockCategory
         */
        $blockCategory = $this->instanceManager->getInstance(SchemaConfigurationBlockCategory::class);
        return $blockCategory;
    }

    protected function isDynamicBlock(): bool
    {
        return true;
    }

    public function getEnablingModule(): ?string
    {
        return SchemaTypeModuleResolver::SCHEMA_ADMIN_SCHEMA;
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function renderBlock(array $attributes, string $content): string
    {
        // Append "-front" because this style must be used only on the client, not on the admin
        $className = $this->getBlockClassName() . '-front';

        $blockContentPlaceholder = '<p><strong>%s</strong> %s</p>';

        $enabledDisabledLabels = [
            self::ATTRIBUTE_VALUE_ENABLED => \__('✅ Yes', 'graphql-api'),
            self::ATTRIBUTE_VALUE_DISABLED => \__('❌ No', 'graphql-api'),
        ];
        $blockContent = sprintf(
            $blockContentPlaceholder,
            \__('Add admin fields to schema?', 'graphql-api'),
            $enabledDisabledLabels[$attributes[self::ATTRIBUTE_NAME_ENABLE_ADMIN_SCHEMA] ?? ''] ?? ComponentConfiguration::getSettingsValueLabel()
        );

        $blockContentPlaceholder = <<<EOT
        <div class="%s">
            <h3 class="%s">%s</h3>
            %s
        </div>
EOT;
        return sprintf(
            $blockContentPlaceholder,
            $className . ' ' . $this->getAlignClass(),
            $className . '__title',
            \__('Schema for the Admin', 'graphql-api'),
            $blockContent
        );
    }

    /**
     * Pass localized data to the block
     *
     * @return array<string, mixed>
     */
    protected function getLocalizedData(): array
    {
        return array_merge(
            parent::getLocalizedData(),
            [
                'isAdminSchemaEnabled' => $this->moduleRegistry->isModuleEnabled(SchemaTypeModuleResolver::SCHEMA_ADMIN_SCHEMA),
            ]
        );
    }

    /**
     * Register index.css
     */
    protected function registerEditorCSS(): bool
    {
        return true;
    }
    /**
     * Register style-index.css
     */
    protected function registerCommonStyleCSS(): bool
    {
        return true;
    }
}
