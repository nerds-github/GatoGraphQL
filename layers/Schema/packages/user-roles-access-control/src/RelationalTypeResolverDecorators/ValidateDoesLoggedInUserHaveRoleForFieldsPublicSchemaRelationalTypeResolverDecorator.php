<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\RelationalTypeResolverDecorators;

use PoP\AccessControl\RelationalTypeResolverDecorators\AbstractPublicSchemaRelationalTypeResolverDecorator;
use PoP\AccessControl\RelationalTypeResolverDecorators\ConfigurableAccessControlForFieldsRelationalTypeResolverDecoratorTrait;
use PoP\AccessControl\Services\AccessControlManagerInterface;
use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver;
use PoPSchema\UserRolesAccessControl\Services\AccessControlGroups;
use Symfony\Contracts\Service\Attribute\Required;

class ValidateDoesLoggedInUserHaveRoleForFieldsPublicSchemaRelationalTypeResolverDecorator extends AbstractPublicSchemaRelationalTypeResolverDecorator
{
    use ConfigurableAccessControlForFieldsRelationalTypeResolverDecoratorTrait;
    use ValidateDoesLoggedInUserHaveRolePublicSchemaRelationalTypeResolverDecoratorTrait;

    protected ?AccessControlManagerInterface $accessControlManager = null;
    protected ?ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleDirectiveResolver = null;

    #[Required]
    final public function autowireValidateDoesLoggedInUserHaveRoleForFieldsPublicSchemaRelationalTypeResolverDecorator(
        AccessControlManagerInterface $accessControlManager,
        ValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleDirectiveResolver,
    ): void {
        $this->accessControlManager = $accessControlManager;
        $this->validateDoesLoggedInUserHaveAnyRoleDirectiveResolver = $validateDoesLoggedInUserHaveAnyRoleDirectiveResolver;
    }

    protected function getConfigurationEntries(): array
    {
        return $this->getAccessControlManager()->getEntriesForFields(AccessControlGroups::ROLES);
    }

    protected function getValidateRoleDirectiveResolver(): DirectiveResolverInterface
    {
        return $this->getValidateDoesLoggedInUserHaveAnyRoleDirectiveResolver();
    }
}
