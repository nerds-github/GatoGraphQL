<?php

declare(strict_types=1);

namespace PoP\Multisite\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoP\Multisite\ObjectModels\Site;
use PoP\Multisite\RelationalTypeDataLoaders\ObjectType\SiteTypeDataLoader;
use Symfony\Contracts\Service\Attribute\Required;

class SiteObjectTypeResolver extends AbstractObjectTypeResolver
{
    protected ?SiteTypeDataLoader $siteTypeDataLoader = null;

    #[Required]
    final public function autowireSiteObjectTypeResolver(
        SiteTypeDataLoader $siteTypeDataLoader,
    ): void {
        $this->getSite()TypeDataLoader = $siteTypeDataLoader;
    }

    public function getTypeName(): string
    {
        return 'Site';
    }

    public function getTypeDescription(): ?string
    {
        return $this->getTranslationAPI()->__('Obtain properties belonging to the site (name, domain, configuration options, etc)', 'multisite');
    }

    public function getID(object $object): string | int | null
    {
        /** @var Site */
        $site = $object;
        return $site->getID();
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getSite()TypeDataLoader;
    }
}
