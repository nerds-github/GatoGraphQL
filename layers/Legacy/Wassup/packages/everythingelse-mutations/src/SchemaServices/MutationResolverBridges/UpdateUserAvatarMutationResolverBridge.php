<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\GraphQLParser\Spec\Parser\Ast\Argument;
use PoP\GraphQLParser\StaticHelpers\LocationHelper;
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\Literal;
use PoP\GraphQLParser\Spec\Parser\Ast\WithArgumentsInterface;
use PoP\Root\App;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\UpdateUserAvatarMutationResolver;

class UpdateUserAvatarMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    private ?UpdateUserAvatarMutationResolver $updateUserAvatarMutationResolver = null;
    
    final public function setUpdateUserAvatarMutationResolver(UpdateUserAvatarMutationResolver $updateUserAvatarMutationResolver): void
    {
        $this->updateUserAvatarMutationResolver = $updateUserAvatarMutationResolver;
    }
    final protected function getUpdateUserAvatarMutationResolver(): UpdateUserAvatarMutationResolver
    {
        return $this->updateUserAvatarMutationResolver ??= $this->instanceManager->getInstance(UpdateUserAvatarMutationResolver::class);
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUpdateUserAvatarMutationResolver();
    }

    public function addArgumentsForMutation(WithArgumentsInterface $withArgumentsAST): void
    {
        $user_id = App::getState('is-user-logged-in') ? App::getState('current-user-id') : '';
        $withArgumentsAST->addArgument(new Argument('user_id', new Literal($user_id, LocationHelper::getNonSpecificLocation()), LocationHelper::getNonSpecificLocation()));
    }
}
