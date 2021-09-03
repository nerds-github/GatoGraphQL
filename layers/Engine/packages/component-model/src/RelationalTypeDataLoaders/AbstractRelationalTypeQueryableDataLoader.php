<?php

declare(strict_types=1);

namespace PoP\ComponentModel\RelationalTypeDataLoaders;

use PoP\ComponentModel\Constants\Params;
use PoP\ComponentModel\Facades\ModuleProcessors\ModuleProcessorManagerFacade;
use PoP\ComponentModel\ModuleProcessors\DataloadingConstants;
use PoP\ComponentModel\ModuleProcessors\FilterDataModuleProcessorInterface;
use PoP\Hooks\Facades\HooksAPIFacade;

abstract class AbstractRelationalTypeQueryableDataLoader extends AbstractRelationalTypeDataLoader implements TypeQueryableDataLoaderInterface
{
    /**
     * @return mixed[]
     */
    abstract public function executeQuery($query, array $options = []): array;

    public function executeQueryIDs($query): array
    {
        return $this->executeQuery($query);
    }

    protected function getPagenumberParam($query_args)
    {
        return HooksAPIFacade::getInstance()->applyFilters(
            'GD_Dataloader_List:query:pagenumber',
            $query_args[Params::PAGE_NUMBER]
        );
    }
    protected function getLimitParam($query_args)
    {
        return HooksAPIFacade::getInstance()->applyFilters(
            'GD_Dataloader_List:query:limit',
            $query_args[Params::LIMIT]
        );
    }

    public function findIDs(array $data_properties): array
    {
        $query_args = $data_properties[DataloadingConstants::QUERYARGS];

        // If already indicating the ids to get back, then already return them
        if ($include = $query_args['include'] ?? null) {
            return $include;
        }

        // Customize query
        $query = $this->getQuery($query_args);

        // Allow URE to modify the role, limiting selected users and excluding others, like 'subscriber'
        $query = HooksAPIFacade::getInstance()->applyFilters(self::class . ':gd_dataload_query', $query, $data_properties);

        // Apply filtering of the data
        if ($filtering_modules = $data_properties[DataloadingConstants::QUERYARGSFILTERINGMODULES] ?? null) {
            $moduleprocessor_manager = ModuleProcessorManagerFacade::getInstance();
            foreach ($filtering_modules as $module) {
                /** @var FilterDataModuleProcessorInterface */
                $filterDataModuleProcessor = $moduleprocessor_manager->getProcessor($module);
                $filterDataModuleProcessor->filterHeadmoduleDataloadQueryArgs($module, $query);
            }
        }

        // Execute the query, get ids
        $ids = $this->executeQueryIDs($query);

        return $ids;
    }

    /**
     * Function to override
     */
    public function getQueryToRetrieveObjectsForIDs(array $ids): array
    {
        return array();
    }

    public function getObjects(array $ids): array
    {
        $query = $this->getQueryToRetrieveObjectsForIDs($ids);
        return $this->executeQuery($query);
    }

    protected function getOrderbyDefault()
    {
        return '';
    }

    protected function getOrderDefault()
    {
        return '';
    }

    protected function getQueryHookName()
    {
        return 'Dataloader_ListTrait:query';
    }

    public function getQuery($query_args): array
    {
        // Use all the query params already provided in the query args
        $query = $query_args;

        // Allow to check for "loading-latest"
        $limit = $this->getLimitParam($query_args);
        $query['limit'] = $limit;
        $pagenumber = $this->getPagenumberParam($query_args);
        if ($pagenumber >= 2) {
            $query['offset'] = ($pagenumber - 1) * $limit;
        }
        // Params and values by default
        if (!isset($query['orderby'])) {
            $query['orderby'] = $this->getOrderbyDefault();
        }
        if (!isset($query['order'])) {
            $query['order'] = $this->getOrderDefault();
        }

        // Allow CoAuthors Plus to modify the query to add the coauthors
        return HooksAPIFacade::getInstance()->applyFilters(
            $this->getQueryHookName(),
            $query,
            $query_args
        );
    }
}
