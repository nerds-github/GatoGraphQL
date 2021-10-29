<?php

declare(strict_types=1);

namespace PoPSchema\UserState\Hooks;

use PoP\Hooks\AbstractHookSet;
use PoPSchema\UserState\FieldResolvers\ObjectType\GlobalObjectTypeFieldResolver;
use Symfony\Contracts\Service\Attribute\Required;

class DBEntriesHookSet extends AbstractHookSet
{
    protected ?GlobalObjectTypeFieldResolver $globalObjectTypeFieldResolver = null;

    #[Required]
    final public function autowireDBEntriesHookSet(
        GlobalObjectTypeFieldResolver $globalObjectTypeFieldResolver
    ): void {
        $this->globalObjectTypeFieldResolver = $globalObjectTypeFieldResolver;
    }

    protected function init(): void
    {
        $this->getHooksAPI()->addFilter(
            'PoP\ComponentModel\Engine:moveEntriesUnderDBName:dbName-dataFields',
            array($this, 'moveEntriesUnderDBName'),
            10,
            1
        );
    }

    public function moveEntriesUnderDBName(array $dbname_datafields): array
    {
        $dbname_datafields['userstate'] = $this->getHooksAPI()->applyFilters(
            'PoPSchema\UserState\DataloaderHooks:metaFields',
            $this->getGlobalObjectTypeFieldResolver()->getFieldNamesToResolve()
        );
        return $dbname_datafields;
    }
}
