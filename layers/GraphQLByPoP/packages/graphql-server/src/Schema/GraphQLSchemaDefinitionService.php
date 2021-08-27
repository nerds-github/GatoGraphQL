<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\Schema;

use PoP\ComponentModel\State\ApplicationState;
use PoP\Engine\Schema\SchemaDefinitionService;
use PoP\API\ComponentConfiguration as APIComponentConfiguration;
use GraphQLByPoP\GraphQLServer\TypeResolvers\QueryRootTypeResolver;
use GraphQLByPoP\GraphQLServer\TypeResolvers\MutationRootTypeResolver;
use GraphQLByPoP\GraphQLServer\Schema\GraphQLSchemaDefinitionServiceInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;

class GraphQLSchemaDefinitionService extends SchemaDefinitionService implements GraphQLSchemaDefinitionServiceInterface
{
    public function __construct(protected InstanceManagerInterface $instanceManager)
    {        
    }
    protected function getTypeResolverTypeSchemaKey(string $typeResolverClass): string
    {
        $typeResolver = $this->instanceManager->getInstance($typeResolverClass);
        return $this->getTypeSchemaKey($typeResolver);
    }

    public function getRootOrQueryRootTypeSchemaKey(): string
    {
        $queryTypeResolverClass = $this->getRootOrQueryRootTypeResolverClass();
        return $this->getTypeResolverTypeSchemaKey($queryTypeResolverClass);
    }

    /**
     * If nested mutations are enabled, use "Root".
     * Otherwise, use "Query"
     */
    public function getRootOrQueryRootTypeResolverClass(): string
    {
        $vars = ApplicationState::getVars();
        return $vars['nested-mutations-enabled'] ?
            $this->getRootTypeResolverClass()
            : $this->getQueryRootTypeResolverClass();
    }

    public function getQueryRootTypeSchemaKey(): string
    {
        $queryTypeResolverClass = $this->getQueryRootTypeResolverClass();
        return $this->getTypeResolverTypeSchemaKey($queryTypeResolverClass);
    }

    public function getQueryRootTypeResolverClass(): string
    {
        return QueryRootTypeResolver::class;
    }

    public function getRootOrMutationRootTypeSchemaKey(): ?string
    {
        if ($mutationTypeResolverClass = $this->getRootOrMutationRootTypeResolverClass()) {
            return $this->getTypeResolverTypeSchemaKey($mutationTypeResolverClass);
        }
        return null;
    }

    /**
     * If nested mutations are enabled, use "Root".
     * Otherwise, use "Mutation"
     */
    public function getRootOrMutationRootTypeResolverClass(): ?string
    {
        if (!APIComponentConfiguration::enableMutations()) {
            return null;
        }
        $vars = ApplicationState::getVars();
        return $vars['nested-mutations-enabled'] ?
            $this->getRootTypeResolverClass()
            : $this->getMutationRootTypeResolverClass();
    }

    public function getMutationRootTypeSchemaKey(): ?string
    {
        if ($mutationTypeResolverClass = $this->getMutationRootTypeResolverClass()) {
            return $this->getTypeResolverTypeSchemaKey($mutationTypeResolverClass);
        }
        return null;
    }

    /**
     * If nested mutations are enabled, use "Root".
     * Otherwise, use "Mutation"
     */
    public function getMutationRootTypeResolverClass(): ?string
    {
        if (!APIComponentConfiguration::enableMutations()) {
            return null;
        }
        return MutationRootTypeResolver::class;
    }

    public function getSubscriptionRootTypeSchemaKey(): ?string
    {
        if ($subscriptionTypeResolverClass = $this->getSubscriptionRootTypeResolverClass()) {
            return $this->getTypeResolverTypeSchemaKey($subscriptionTypeResolverClass);
        }
        return null;
    }

    /**
     * @todo Implement
     */
    public function getSubscriptionRootTypeResolverClass(): ?string
    {
        return null;
    }
}
