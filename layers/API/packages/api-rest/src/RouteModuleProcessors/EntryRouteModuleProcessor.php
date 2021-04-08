<?php

declare(strict_types=1);

namespace PoP\RESTAPI\RouteModuleProcessors;

use PoP\ComponentModel\State\ApplicationState;
use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\API\Facades\FieldQueryConvertorFacade;
use PoP\Routing\RouteNatures;
use PoP\API\ModuleProcessors\RootRelationalFieldDataloadModuleProcessor;
use PoP\API\Response\Schemes as APISchemes;

class EntryRouteModuleProcessor extends AbstractRESTEntryRouteModuleProcessor
{
    private static ?string $restFieldsQuery = null;
    private static array $restFields = [];
    public static function getRESTFields(): array
    {
        if (is_null(self::$restFields)) {
            $restFields = self::getRESTFieldsQuery();
            $fieldQueryConvertor = FieldQueryConvertorFacade::getInstance();
            $fieldQuerySet = $fieldQueryConvertor->convertAPIQuery($restFields);
            self::$restFields = $fieldQuerySet->getRequestedFieldQuery();
        }
        return self::$restFields;
    }
    public static function getRESTFieldsQuery(): string
    {
        if (is_null(self::$restFieldsQuery)) {
            self::$restFieldsQuery = (string) HooksAPIFacade::getInstance()->applyFilters(
                'Root:RESTFields',
                'fullSchema'
            );
        }
        return self::$restFieldsQuery;
    }
    /**
     * @return array<string, array<array>>
     */
    public function getModulesVarsPropertiesByNature(): array
    {
        $ret = array();

        $vars = ApplicationState::getVars();
        $ret[RouteNatures::HOME][] = [
            'module' => [RootRelationalFieldDataloadModuleProcessor::class, RootRelationalFieldDataloadModuleProcessor::MODULE_DATALOAD_RELATIONALFIELDS_ROOT, ['fields' => isset($vars['query']) ? $vars['query'] : self::getRESTFields()]],
            'conditions' => [
                'scheme' => APISchemes::API,
                'datastructure' => $this->restDataStructureFormatter->getName(),
            ],
        ];

        return $ret;
    }
}
