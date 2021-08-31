<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\TypeDataLoaders;

use PoP\ComponentModel\TypeDataLoaders\AbstractTypeQueryableDataLoader;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPSchema\CustomPostsWP\TypeAPIs\CustomPostTypeAPIUtils;
use PoPSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPSchema\SchemaCommons\Constants\QueryOptions;

abstract class AbstractCustomPostTypeDataLoader extends AbstractTypeQueryableDataLoader
{
    public function getObjectQuery(array $ids): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return array(
            'include' => $ids,
            'status' => CustomPostTypeAPIUtils::getPostStatuses(),
        );
    }

    public function getObjects(array $ids): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        $query = $this->getObjectQuery($ids);
        return $customPostTypeAPI->getCustomPosts($query);
    }

    public function getDataFromIdsQuery(array $ids): array
    {
        return [
            'include' => $ids,
            'status' => CustomPostTypeAPIUtils::getPostStatuses(),
        ];
    }

    public function executeQuery($query, array $options = []): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return $customPostTypeAPI->getCustomPosts($query, $options);
    }

    protected function getOrderbyDefault()
    {
        return $this->nameResolver->getName('popcms:dbcolumn:orderby:customposts:date');
    }

    protected function getOrderDefault()
    {
        return 'DESC';
    }

    public function executeQueryIds($query): array
    {
        $options = [
            QueryOptions::RETURN_TYPE => ReturnTypes::IDS,
        ];
        return $this->executeQuery($query, $options);
    }

    protected function getLimitParam($query_args)
    {
        return $this->hooksAPI->applyFilters(
            'CustomPostTypeDataLoader:query:limit',
            parent::getLimitParam($query_args)
        );
    }

    protected function getQueryHookName()
    {
        // Allow to add the timestamp for loadingLatest
        return 'CustomPostTypeDataLoader:query';
    }
}
