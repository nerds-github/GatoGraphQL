<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Mutation;

use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\InputObject;
use PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface;
use stdClass;

class InputObjectUnderFieldArgumentFieldDataProvider extends FieldDataProvider implements InputObjectUnderFieldArgumentFieldDataProviderInterface
{
    public function __construct(
        FieldInterface $field,
        protected string $fieldInputArgumentName,
        array $customValues = [],
    ) {
        parent::__construct($field, $customValues);
    }

    /**
     * @return string[]
     */
    protected function getPropertiesInField(): array
    {
        $inputObjectValue = $this->getInputObjectValue();
        return array_keys((array) $inputObjectValue);
    }

    protected function hasInField(string $propertyName): bool
    {
        $inputObjectValue = $this->getInputObjectValue();
        return property_exists($inputObjectValue, $propertyName);
    }

    protected function getFromField(string $propertyName): mixed
    {
        $inputObjectValue = $this->getInputObjectValue();
        return $inputObjectValue->$propertyName;
    }

    protected function getInputObjectValue(): stdClass
    {
        return $this->getInputObject()->getValue();
    }

    final protected function getInputObject(): InputObject
    {
        $argument = $this->field->getArgument($this->getArgumentName());
        /** @var InputObject */
        return $argument->getValueAST();
    }

    public function getArgumentName(): string
    {
        return $this->fieldInputArgumentName;
    }
}
