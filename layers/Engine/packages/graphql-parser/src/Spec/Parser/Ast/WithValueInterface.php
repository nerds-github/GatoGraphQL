<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\Spec\Parser\Ast;

interface WithValueInterface
{
    public function getValue(): mixed;
}
