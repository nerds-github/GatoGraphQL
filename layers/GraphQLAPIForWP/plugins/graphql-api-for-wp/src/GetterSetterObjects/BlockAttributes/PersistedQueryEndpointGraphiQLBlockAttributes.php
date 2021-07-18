<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\GetterSetterObjects\BlockAttributes;

class PersistedQueryEndpointGraphiQLBlockAttributes
{
    public function __construct(
        protected ?string $query,
        /** @var array<string, mixed> */
        protected array $variables,
    ) {
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }
}
