<?php

declare(strict_types=1);

namespace GatoGraphQL\GatoGraphQL\ConditionalOnContext\PROPluginInformation\Overrides\MenuPages;

use GatoGraphQL\GatoGraphQL\Admin\Tables\AbstractItemListTable;
use GatoGraphQL\GatoGraphQL\ConditionalOnContext\PROPluginInformation\Admin\Tables\ModuleListTable;
use GatoGraphQL\GatoGraphQL\Services\MenuPages\ModulesMenuPage as UpstreamModulesMenuPage;

class ModulesMenuPage extends UpstreamModulesMenuPage
{
    /**
     * @return class-string<AbstractItemListTable>
     */
    protected function getTableClass(): string
    {
        return ModuleListTable::class;
    }
}