<?php

declare(strict_types=1);

namespace PoPSchema\GenericCustomPosts\TypeResolvers\InputObjectType;

use PoP\Engine\App;
use PoP\Root\Managers\ComponentManager;
use PoPSchema\GenericCustomPosts\Component;
use PoPSchema\GenericCustomPosts\ComponentConfiguration;
use PoPSchema\SchemaCommons\TypeResolvers\InputObjectType\PaginationInputObjectTypeResolver;

class GenericCustomPostPaginationInputObjectTypeResolver extends PaginationInputObjectTypeResolver
{
    public function getTypeName(): string
    {
        return 'GenericCustomPostPaginationInput';
    }

    public function getTypeDescription(): ?string
    {
        return $this->getTranslationAPI()->__('Input to paginate generic custom posts', 'customposts');
    }

    protected function getDefaultLimit(): ?int
    {
        /** @var ComponentConfiguration */
        $componentConfiguration = App::getComponentManager()->getComponent(Component::class)->getConfiguration();
        return $componentConfiguration->getGenericCustomPostListDefaultLimit();
    }

    protected function getMaxLimit(): ?int
    {
        /** @var ComponentConfiguration */
        $componentConfiguration = App::getComponentManager()->getComponent(Component::class)->getConfiguration();
        return $componentConfiguration->getGenericCustomPostListMaxLimit();
    }
}
