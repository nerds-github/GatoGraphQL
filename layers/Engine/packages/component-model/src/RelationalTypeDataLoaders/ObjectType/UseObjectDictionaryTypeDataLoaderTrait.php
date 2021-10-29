<?php

declare(strict_types=1);

namespace PoP\ComponentModel\RelationalTypeDataLoaders\ObjectType;

use PoP\ComponentModel\Container\ObjectDictionaryInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait UseObjectDictionaryTypeDataLoaderTrait
{
    protected ?ObjectDictionaryInterface $objectDictionary = null;

    #[Required]
    public function autowireUseObjectDictionaryTypeDataLoaderTrait(
        ObjectDictionaryInterface $objectDictionary,
    ): void {
        $this->objectDictionary = $objectDictionary;
    }

    public function getObjects(array $ids): array
    {
        $objectTypeResolverClass = get_class($this->getObjectTypeResolver());
        $ret = [];
        foreach ($ids as $id) {
            if (!$this->getObjectDictionary()->has($objectTypeResolverClass, $id)) {
                $this->getObjectDictionary()->set($objectTypeResolverClass, $id, $this->getObjectTypeNewInstance($id));
            }
            $ret[] = $this->getObjectDictionary()->get($objectTypeResolverClass, $id);
        }
        return $ret;
    }

    abstract protected function getObjectTypeResolver(): ObjectTypeResolverInterface;
    abstract protected function getObjectTypeNewInstance(int | string $id): mixed;
}
