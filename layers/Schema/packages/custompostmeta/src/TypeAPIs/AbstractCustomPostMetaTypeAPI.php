<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostMeta\TypeAPIs;

use PoPSchema\CustomPostMeta\ComponentConfiguration;
use PoPSchema\SchemaCommons\Services\AllowOrDenySettingsServiceInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractCustomPostMetaTypeAPI implements CustomPostMetaTypeAPIInterface
{
    protected ?AllowOrDenySettingsServiceInterface $allowOrDenySettingsService = null;

    #[Required]
    final public function autowireAbstractCustomPostMetaTypeAPI(AllowOrDenySettingsServiceInterface $allowOrDenySettingsService): void
    {
        $this->allowOrDenySettingsService = $allowOrDenySettingsService;
    }

    final public function getCustomPostMeta(string | int $customPostID, string $key, bool $single = false): mixed
    {
        /**
         * Check if the allow/denylist validation fails
         * Compare for full match or regex
         */
        $entries = ComponentConfiguration::getCustomPostMetaEntries();
        $behavior = ComponentConfiguration::getCustomPostMetaBehavior();
        if (!$this->getAllowOrDenySettingsService()->isEntryAllowed($key, $entries, $behavior)) {
            return null;
        }
        return $this->doGetCustomPostMeta($customPostID, $key, $single);
    }

    abstract protected function doGetCustomPostMeta(string | int $customPostID, string $key, bool $single = false): mixed;
}
