<?php

declare(strict_types=1);

namespace PoP\ComponentModel\MutationResolverBridges;

interface ComponentMutationResolverBridgeInterface
{
    /**
     * @return array<string, mixed>|null
     */
    public function executeMutation(array &$data_properties): ?array;
    public function getMutationResolver(): \PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
    public function getFormData(): array;
}
