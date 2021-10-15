<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\ObjectModels;

interface NamedTypeInterface extends TypeInterface
{
    public function getNamespacedName(): string;

    public function getElementName(): string;

    /**
     * @return array<string, mixed>
     */
    public function getExtensions(): array;
}
