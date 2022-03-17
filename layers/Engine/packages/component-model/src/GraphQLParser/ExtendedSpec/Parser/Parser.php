<?php

declare(strict_types=1);

namespace PoP\ComponentModel\GraphQLParser\ExtendedSpec\Parser;

use PoP\ComponentModel\App;
use PoP\ComponentModel\DirectiveResolvers\MetaDirectiveResolverInterface;
use PoP\ComponentModel\Registries\MetaDirectiveRegistryInterface;
use PoP\GraphQLParser\Component;
use PoP\GraphQLParser\ComponentConfiguration;
use PoP\GraphQLParser\ExtendedSpec\Parser\AbstractParser;
use PoP\GraphQLParser\ExtendedSpec\Parser\Ast\ArgumentValue\DynamicVariableReference;
use PoP\GraphQLParser\Spec\Parser\Ast\Argument;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\Variable;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\VariableReference;
use PoP\GraphQLParser\Spec\Parser\Ast\Directive;
use PoP\GraphQLParser\Spec\Parser\Location;

class Parser extends AbstractParser
{
    private ?MetaDirectiveRegistryInterface $metaDirectiveRegistry = null;

    final public function setMetaDirectiveRegistry(MetaDirectiveRegistryInterface $metaDirectiveRegistry): void
    {
        $this->metaDirectiveRegistry = $metaDirectiveRegistry;
    }
    final protected function getMetaDirectiveRegistry(): MetaDirectiveRegistryInterface
    {
        return $this->metaDirectiveRegistry ??= $this->instanceManager->getInstance(MetaDirectiveRegistryInterface::class);
    }

    protected function isMetaDirective(string $directiveName): bool
    {
        $metaDirectiveResolver = $this->getMetaDirectiveResolver($directiveName);
        return $metaDirectiveResolver !== null;
    }

    protected function getMetaDirectiveResolver(string $directiveName): ?MetaDirectiveResolverInterface
    {
        return $this->getMetaDirectiveRegistry()->getMetaDirectiveResolver($directiveName);
    }

    protected function getAffectDirectivesUnderPosArgument(
        Directive $directive,
    ): ?Argument {
        /** @var MetaDirectiveResolverInterface */
        $metaDirectiveResolver = $this->getMetaDirectiveResolver($directive->getName());
        $affectDirectivesUnderPosArgumentName = $metaDirectiveResolver->getAffectDirectivesUnderPosArgumentName();
        foreach ($directive->getArguments() as $argument) {
            if ($argument->getName() !== $affectDirectivesUnderPosArgumentName) {
                continue;
            }
            return $argument;
        }
        return null;
    }

    protected function getAffectDirectivesUnderPosArgumentDefaultValue(
        Directive $directive,
    ): mixed {
        /** @var MetaDirectiveResolverInterface */
        $metaDirectiveResolver = $this->getMetaDirectiveResolver($directive->getName());
        return $metaDirectiveResolver->getAffectDirectivesUnderPosArgumentDefaultValue();
    }

    final protected function isDynamicVariableReference(
        string $name,
        ?Variable $variable,
    ): bool {
        return $variable === null && \str_starts_with($this->name, '_');
    }

    protected function createVariableReference(
        string $name,
        ?Variable $variable,
        Location $location,
    ): VariableReference {
        /** @var ComponentConfiguration */
        $componentConfiguration = App::getComponent(Component::class)->getConfiguration();
        if ($componentConfiguration->enableDynamicVariables()
            && $this->isDynamicVariableReference($name, $variable)
        ) {
            return new DynamicVariableReference($name, $variable, $location);
        }

        return parent::createVariableReference(
            $name,
            $variable,
            $location,
        );
    }
}
