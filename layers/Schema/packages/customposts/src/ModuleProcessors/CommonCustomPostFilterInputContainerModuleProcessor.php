<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\ModuleProcessors;

use PoPSchema\CustomPosts\ModuleProcessors\FormInputs\FilterInputModuleProcessor;
use PoPSchema\SchemaCommons\ModuleProcessors\AbstractFilterInputContainerModuleProcessor;
use PoPSchema\SchemaCommons\ModuleProcessors\FormInputs\CommonFilterInputModuleProcessor;

class CommonCustomPostFilterInputContainerModuleProcessor extends AbstractFilterInputContainerModuleProcessor
{
    public const HOOK_FILTER_INPUTS = __CLASS__ . ':filter-inputs';

    public const MODULE_FILTERINPUTCONTAINER_CUSTOMPOST_BY_ID = 'filterinputcontainer-custompost-by-id';
    public const MODULE_FILTERINPUTCONTAINER_CUSTOMPOST_BY_ID_AND_STATUS = 'filterinputcontainer-custompost-by-id-and-status';

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOST_BY_ID],
            [self::class, self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOST_BY_ID_AND_STATUS],
        );
    }

    public function getFilterInputModules(array $module): array
    {
        return match ($module[1]) {
            self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOST_BY_ID => [
                [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_ID],
            ],
            self::MODULE_FILTERINPUTCONTAINER_CUSTOMPOST_BY_ID_AND_STATUS => [
                [CommonFilterInputModuleProcessor::class, CommonFilterInputModuleProcessor::MODULE_FILTERINPUT_ID],
                [FilterInputModuleProcessor::class, FilterInputModuleProcessor::MODULE_FILTERINPUT_CUSTOMPOSTSTATUS],
            ],
            default => [],
        };
    }

    /**
     * @return string[]
     */
    protected function getFilterInputHookNames(): array
    {
        return [
            ...parent::getFilterInputHookNames(),
            self::HOOK_FILTER_INPUTS,
        ];
    }
}
