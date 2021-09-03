<?php

declare(strict_types=1);

namespace PoPSchema\Menus\RelationalTypeDataLoaders;

use PoP\ComponentModel\RelationalTypeDataLoaders\AbstractRelationalTypeDataLoader;
use PoPSchema\Menus\Facades\MenuTypeAPIFacade;

class MenuTypeDataLoader extends AbstractRelationalTypeDataLoader
{
    public function getObjects(array $ids): array
    {
        $menuTypeAPI = MenuTypeAPIFacade::getInstance();
        // If the menu doesn't exist, remove the `null` entry
        return array_filter(array_map(
            fn (string | int $id) => $menuTypeAPI->getMenu($id),
            $ids
        ));
    }
}
