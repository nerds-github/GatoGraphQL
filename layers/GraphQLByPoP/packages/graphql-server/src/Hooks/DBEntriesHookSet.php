<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\Hooks;

use PoP\Root\App;
use PoP\Root\Hooks\AbstractHookSet;
use PoPAPI\API\Hooks\DBEntriesHookSet as UpstreamDBEntriesHookSet;

class DBEntriesHookSet extends AbstractHookSet
{
    protected function init(): void
    {
        App::addFilter(
            UpstreamDBEntriesHookSet::HOOK_MOVE_ENTRIES_UNDER_DB_NAME_META_FIELDS,
            $this->moveEntriesUnderDBName(...)
        );
    }

    /**
     * All fields starting with "__" (such as "__schema") are meta
     *
     * @param string[] $metaFields
     * @return string[]
     */
    public function moveEntriesUnderDBName(array $metaFields): array
    {
        $metaFields[] = '__schema';
        $metaFields[] = '__typename';
        $metaFields[] = '__type';
        return $metaFields;
    }
}
