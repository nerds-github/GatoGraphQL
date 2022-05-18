<?php

declare(strict_types=1);

namespace PoPCMSSchema\Categories\ConditionalOnModule\API\ComponentProcessors;

use PoPAPI\API\ComponentProcessors\AbstractRelationalFieldDataloadComponentProcessor;
use PoP\ComponentModel\QueryInputOutputHandlers\ListQueryInputOutputHandler;
use PoP\ComponentModel\QueryInputOutputHandlers\QueryInputOutputHandlerInterface;
use PoPCMSSchema\Categories\ComponentProcessors\CategoryFilterInputContainerComponentProcessor;
use PoPCMSSchema\QueriedObject\ComponentProcessors\QueriedDBObjectComponentProcessorTrait;

abstract class AbstractFieldDataloadComponentProcessor extends AbstractRelationalFieldDataloadComponentProcessor
{
    use QueriedDBObjectComponentProcessorTrait;

    public final const MODULE_DATALOAD_RELATIONALFIELDS_CATEGORY = 'dataload-relationalfields-category';
    public final const MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYLIST = 'dataload-relationalfields-categorylist';
    public final const MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYCOUNT = 'dataload-relationalfields-categorycount';

    private ?ListQueryInputOutputHandler $listQueryInputOutputHandler = null;

    final public function setListQueryInputOutputHandler(ListQueryInputOutputHandler $listQueryInputOutputHandler): void
    {
        $this->listQueryInputOutputHandler = $listQueryInputOutputHandler;
    }
    final protected function getListQueryInputOutputHandler(): ListQueryInputOutputHandler
    {
        return $this->listQueryInputOutputHandler ??= $this->instanceManager->getInstance(ListQueryInputOutputHandler::class);
    }

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORY],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYLIST],
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYCOUNT],
        );
    }

    public function getObjectIDOrIDs(array $componentVariation, array &$props, &$data_properties): string | int | array | null
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORY:
                return $this->getQueriedDBObjectID($componentVariation, $props, $data_properties);
        }

        return parent::getObjectIDOrIDs($componentVariation, $props, $data_properties);
    }

    public function getQueryInputOutputHandler(array $componentVariation): ?QueryInputOutputHandlerInterface
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYLIST:
                return $this->getListQueryInputOutputHandler();
        }

        return parent::getQueryInputOutputHandler($componentVariation);
    }

    public function getFilterSubmodule(array $componentVariation): ?array
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYLIST:
                return [CategoryFilterInputContainerComponentProcessor::class, CategoryFilterInputContainerComponentProcessor::MODULE_FILTERINPUTCONTAINER_CATEGORIES];
            case self::MODULE_DATALOAD_RELATIONALFIELDS_CATEGORYCOUNT:
                return [CategoryFilterInputContainerComponentProcessor::class, CategoryFilterInputContainerComponentProcessor::MODULE_FILTERINPUTCONTAINER_CATEGORYCOUNT];
        }

        return parent::getFilterSubmodule($componentVariation);
    }
}
