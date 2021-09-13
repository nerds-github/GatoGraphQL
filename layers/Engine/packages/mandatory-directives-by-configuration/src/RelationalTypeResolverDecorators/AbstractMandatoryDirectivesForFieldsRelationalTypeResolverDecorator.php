<?php

declare(strict_types=1);

namespace PoP\MandatoryDirectivesByConfiguration\RelationalTypeResolverDecorators;

use PoP\ComponentModel\RelationalTypeResolverDecorators\AbstractRelationalTypeResolverDecorator;
use PoP\MandatoryDirectivesByConfiguration\RelationalTypeResolverDecorators\ConfigurableMandatoryDirectivesForFieldsRelationalTypeResolverDecoratorTrait;

abstract class AbstractMandatoryDirectivesForFieldsRelationalTypeResolverDecorator extends AbstractRelationalTypeResolverDecorator
{
    use ConfigurableMandatoryDirectivesForFieldsRelationalTypeResolverDecoratorTrait;
}
