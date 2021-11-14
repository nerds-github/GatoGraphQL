<?php

declare(strict_types=1);

namespace PoP\Engine\TypeResolvers\ScalarType;

use PoP\ComponentModel\TypeResolvers\ScalarType\AbstractScalarTypeResolver;
use stdClass;

class AnyBuiltInScalarScalarTypeResolver extends AbstractScalarTypeResolver
{
    public function getTypeName(): string
    {
        return 'AnyBuiltInScalar';
    }

    public function getTypeDescription(): ?string
    {
        return $this->getTranslationAPI()->__('Wildcard type representing any of GraphQL\'s built-in types (String, Int, Boolean, Float or ID)', 'engine');
    }

    /**
     * Accept anything and everything, other than arrays and objects
     */
    public function coerceValue(string|int|float|bool|stdClass $inputValue): string|int|float|bool|object
    {
        if ($error = $this->validateIsNotStdClass($inputValue)) {
            return $error;
        }
        return $inputValue;
    }
}
