<?php

declare(strict_types=1);

namespace PoPSitesWassup\UserStateMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\UserStateMutations\MutationResolvers\LogoutMutationResolver;

class LogoutMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    private ?LogoutMutationResolver $logoutMutationResolver = null;

    final public function setLogoutMutationResolver(LogoutMutationResolver $logoutMutationResolver): void
    {
        $this->logoutMutationResolver = $logoutMutationResolver;
    }
    final protected function getLogoutMutationResolver(): LogoutMutationResolver
    {
        return $this->logoutMutationResolver ??= $this->instanceManager->getInstance(LogoutMutationResolver::class);
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getLogoutMutationResolver();
    }

    public function getFormData(): array
    {
        return [];
    }
}
