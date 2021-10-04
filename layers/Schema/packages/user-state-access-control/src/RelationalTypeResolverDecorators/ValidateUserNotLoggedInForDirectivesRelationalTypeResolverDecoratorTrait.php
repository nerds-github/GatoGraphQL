<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators;

use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;
use PoPSchema\UserStateAccessControl\ConfigurationEntries\UserStates;
use PoPSchema\UserStateAccessControl\DirectiveResolvers\ValidateIsUserNotLoggedInForDirectivesDirectiveResolver;
use Symfony\Contracts\Service\Attribute\Required;

trait ValidateUserNotLoggedInForDirectivesRelationalTypeResolverDecoratorTrait
{
    protected ValidateIsUserNotLoggedInForDirectivesDirectiveResolver $validateIsUserNotLoggedInForDirectivesDirectiveResolver;

    #[Required]
    final public function autowireValidateUserNotLoggedInForDirectivesRelationalTypeResolverDecoratorTrait(
        ValidateIsUserNotLoggedInForDirectivesDirectiveResolver $validateIsUserNotLoggedInForDirectivesDirectiveResolver,
    ): void {
        $this->validateIsUserNotLoggedInForDirectivesDirectiveResolver = $validateIsUserNotLoggedInForDirectivesDirectiveResolver;
    }

    protected function getRequiredEntryValue(): ?string
    {
        return UserStates::OUT;
    }
    protected function getValidateUserStateDirectiveResolver(): DirectiveResolverInterface
    {
        return $this->validateIsUserNotLoggedInForDirectivesDirectiveResolver;
    }
}
