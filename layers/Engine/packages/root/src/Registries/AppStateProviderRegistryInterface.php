<?php

declare(strict_types=1);

namespace PoP\Root\Registries;

use PoP\Root\Component\AppStateProviderInterface;

interface AccessControlRuleBlockRegistryInterface
{
    public function addAppStateProvider(AppStateProviderInterface $appStateProvider): void;
    /**
     * @return AppStateProviderInterface[]
     */
    public function getAppStateProviders(): array;
}
