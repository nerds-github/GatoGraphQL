<?php

declare(strict_types=1);

namespace PoPWPSchema\Users\Hooks;

use PoP\Hooks\AbstractHookSet;
use PoPSchema\UsersWP\TypeAPIs\UserTypeAPI;
use PoPWPSchema\Users\Constants\UserOrderBy;

class QueryHookSet extends AbstractHookSet
{
    protected function init(): void
    {
        $this->getHooksAPI()->addFilter(
            UserTypeAPI::HOOK_ORDERBY_QUERY_ARG_VALUE,
            [$this, 'getOrderByQueryArgValue']
        );
    }

    public function getOrderByQueryArgValue(string $orderBy): string
    {
        return match ($orderBy) {
            UserOrderBy::USER_URL => 'user_url',
            default => $orderBy,
        };
    }
}
