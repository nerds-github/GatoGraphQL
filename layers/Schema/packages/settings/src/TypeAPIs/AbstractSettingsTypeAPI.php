<?php

declare(strict_types=1);

namespace PoPSchema\Settings\TypeAPIs;

use InvalidArgumentException;
use PoP\ComponentModel\Services\BasicServiceTrait;
use PoPSchema\SchemaCommons\Services\AllowOrDenySettingsServiceInterface;
use PoPSchema\Settings\ComponentConfiguration;

abstract class AbstractSettingsTypeAPI implements SettingsTypeAPIInterface
{
    use BasicServiceTrait;

    private ?AllowOrDenySettingsServiceInterface $allowOrDenySettingsService = null;

    final public function setAllowOrDenySettingsService(AllowOrDenySettingsServiceInterface $allowOrDenySettingsService): void
    {
        $this->allowOrDenySettingsService = $allowOrDenySettingsService;
    }
    final protected function getAllowOrDenySettingsService(): AllowOrDenySettingsServiceInterface
    {
        return $this->allowOrDenySettingsService ??= $this->instanceManager->getInstance(AllowOrDenySettingsServiceInterface::class);
    }

    /**
     * @throws InvalidArgumentException When the option does not exist, or is not in the allowlist
     */
    final public function getOption(string $name): mixed
    {
        /**
         * Check if the allow/denylist validation fails
         * Compare for full match or regex
         */
        $settingsEntries = ComponentConfiguration::getSettingsEntries();
        $settingsBehavior = ComponentConfiguration::getSettingsBehavior();
        if (!$this->getAllowOrDenySettingsService()->isEntryAllowed($name, $settingsEntries, $settingsBehavior)) {
            return throw new InvalidArgumentException(
                sprintf(
                    $this->getTranslationAPI()->__('There is no option with name \'%s\'', 'settings'),
                    $name
                )
            );
        }
        return $this->doGetOption($name);
    }

    abstract protected function doGetOption(string $name): mixed;
}
