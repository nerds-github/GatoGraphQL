<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators;

use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;
use PoPSchema\UserStateAccessControl\ConfigurationEntries\UserStates;
use PoPSchema\UserStateAccessControl\DirectiveResolvers\ValidateIsUserNotLoggedInDirectiveResolver;
use Symfony\Contracts\Service\Attribute\Required;

trait ValidateUserNotLoggedInForFieldsRelationalTypeResolverDecoratorTrait
{
    protected ValidateIsUserNotLoggedInDirectiveResolver $validateIsUserNotLoggedInDirectiveResolver;

    #[Required]
    final public function autowireValidateUserNotLoggedInForFieldsRelationalTypeResolverDecoratorTrait(
        ValidateIsUserNotLoggedInDirectiveResolver $validateIsUserNotLoggedInDirectiveResolver,
    ): void {
        $this->validateIsUserNotLoggedInDirectiveResolver = $validateIsUserNotLoggedInDirectiveResolver;
    }

    protected function removeFieldNameBasedOnMatchingEntryValue($entryValue = null): bool
    {
        return UserStates::OUT == $entryValue;
    }
    protected function getValidateUserStateDirectiveResolver(): DirectiveResolverInterface
    {
        return $this->validateIsUserNotLoggedInDirectiveResolver;
    }
}
