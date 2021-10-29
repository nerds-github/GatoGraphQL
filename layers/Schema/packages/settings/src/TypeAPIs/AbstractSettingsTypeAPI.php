<?php

declare(strict_types=1);

namespace PoPSchema\Settings\TypeAPIs;

use PoPSchema\SchemaCommons\Services\AllowOrDenySettingsServiceInterface;
use PoPSchema\Settings\ComponentConfiguration;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractSettingsTypeAPI implements SettingsTypeAPIInterface
{
    protected ?AllowOrDenySettingsServiceInterface $allowOrDenySettingsService = null;

    #[Required]
    final public function autowireAbstractSettingsTypeAPI(AllowOrDenySettingsServiceInterface $allowOrDenySettingsService): void
    {
        $this->allowOrDenySettingsService = $allowOrDenySettingsService;
    }

    final public function getOption(string $name): mixed
    {
        /**
         * Check if the allow/denylist validation fails
         * Compare for full match or regex
         */
        $settingsEntries = ComponentConfiguration::getSettingsEntries();
        $settingsBehavior = ComponentConfiguration::getSettingsBehavior();
        if (!$this->getAllowOrDenySettingsService()->isEntryAllowed($name, $settingsEntries, $settingsBehavior)) {
            return null;
        }
        return $this->doGetOption($name);
    }

    abstract protected function doGetOption(string $name): mixed;
}
