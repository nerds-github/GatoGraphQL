<?php

declare(strict_types=1);

namespace GatoGraphQL\GatoGraphQL\Services\MenuPageAttachers;

use GatoGraphQL\GatoGraphQL\Services\MenuPages\SettingsMenuPage;

use function add_submenu_page;

trait WithSettingsPageMenuPageAttacherTrait
{
    protected function addSettingsMenuPage(): void
    {
        $menuName = $this->getMenuName();
        $settingsMenuPage = $this->getSettingsMenuPage();
        $menuPageTitle = $settingsMenuPage->getMenuPageTitle();
        if (
            $hookName = add_submenu_page(
                $menuName,
                $menuPageTitle,
                $menuPageTitle,
                'manage_options',
                $this->getSettingsMenuPage()->getScreenID(),
                [$this->getSettingsMenuPage(), 'print'],
            )
        ) {
            $settingsMenuPage->setHookName($hookName);
        }
    }

    abstract protected function getMenuName(): string;
    abstract protected function getSettingsMenuPage(): SettingsMenuPage;
}