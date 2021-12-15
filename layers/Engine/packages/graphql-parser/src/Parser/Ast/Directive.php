<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\Parser\Ast;

use PoP\GraphQLParser\Parser\Location;

class Directive extends AbstractAst
{
    use AstArgumentsTrait;

    /**
     * @param Argument[] $arguments
     */
    public function __construct(private $name, array $arguments, Location $location)
    {
        parent::__construct($location);
        $this->setArguments($arguments);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
