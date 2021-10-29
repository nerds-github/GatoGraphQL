<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks;

use GraphQLAPI\GraphQLAPI\Services\BlockCategories\BlockCategoryInterface;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\SchemaConfigurationBlockCategory;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractSchemaConfigBlock extends AbstractBlock implements SchemaConfigEditorBlockServiceTagInterface
{
    protected ?SchemaConfigurationBlockCategory $schemaConfigurationBlockCategory = null;

    #[Required]
    final public function autowireAbstractSchemaConfigBlock(
        SchemaConfigurationBlockCategory $schemaConfigurationBlockCategory,
    ): void {
        $this->schemaConfigurationBlockCategory = $schemaConfigurationBlockCategory;
    }

    protected function isDynamicBlock(): bool
    {
        return true;
    }

    protected function getBlockCategory(): ?BlockCategoryInterface
    {
        return $this->getSchemaConfigurationBlockCategory();
    }

    public function getBlockPriority(): int
    {
        return 10;
    }
}
