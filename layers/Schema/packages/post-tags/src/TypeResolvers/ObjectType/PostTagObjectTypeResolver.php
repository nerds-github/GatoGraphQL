<?php

declare(strict_types=1);

namespace PoPSchema\PostTags\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoPSchema\PostTags\ComponentContracts\PostTagAPISatisfiedContractTrait;
use PoPSchema\PostTags\RelationalTypeDataLoaders\ObjectType\PostTagTypeDataLoader;
use PoPSchema\Tags\TypeResolvers\ObjectType\AbstractTagObjectTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class PostTagObjectTypeResolver extends AbstractTagObjectTypeResolver
{
    use PostTagAPISatisfiedContractTrait;

    protected ?PostTagTypeDataLoader $postTagTypeDataLoader = null;

    #[Required]
    final public function autowirePostTagObjectTypeResolver(
        PostTagTypeDataLoader $postTagTypeDataLoader,
    ): void {
        $this->postTagTypeDataLoader = $postTagTypeDataLoader;
    }

    public function getTypeName(): string
    {
        return 'PostTag';
    }

    public function getTypeDescription(): ?string
    {
        return $this->getTranslationAPI()->__('Representation of a tag, added to a post', 'post-tags');
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getPostTagTypeDataLoader();
    }
}
