<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\RelationalTypeResolverDecorators;

use PoPSchema\UserRolesAccessControl\Services\AccessControlGroups;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver;
use PoP\AccessControl\RelationalTypeResolverDecorators\AbstractConfigurableAccessControlForDirectivesInPublicSchemaRelationalTypeResolverDecorator;

class ValidateDoesLoggedInUserHaveCapabilityForDirectivesPublicSchemaRelationalTypeResolverDecorator extends AbstractConfigurableAccessControlForDirectivesInPublicSchemaRelationalTypeResolverDecorator
{
    use ValidateDoesLoggedInUserHaveCapabilityPublicSchemaRelationalTypeResolverDecoratorTrait;

    protected function getConfigurationEntries(): array
    {
        return $this->accessControlManager->getEntriesForDirectives(AccessControlGroups::CAPABILITIES);
    }

    protected function getValidateCapabilityDirectiveResolverClass(): string
    {
        return ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver::class;
    }
}
