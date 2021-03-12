<?php

declare(strict_types=1);

namespace PoP\Engine\FormInputs;

use PoP\ComponentModel\PoP_InputUtils;

class MultipleInputFormInput extends MultipleSelectFormInput
{
    public $subnames;

    public function getSubnames()
    {
        return $this->subnames;
    }

    public function __construct($params = array())
    {
        parent::__construct($params);
        $this->subnames = $params['subnames'] ? $params['subnames'] : array();
    }

    protected function getValueFromSource(array $source)
    {
        $name = $this->getName();
        $value = array();
        foreach ($this->getSubnames() as $subname) {
            $fullsubname = PoP_InputUtils::getMultipleInputName($name, $subname);
            if (isset($source[$fullsubname])) {
                $value[$subname] = $source[$fullsubname];
            }
        }

        // Only if there is any subfield value we assign it to $this->selected. Otherwise, it must keep the null value, as to obtain the value from dbObject[dbObjectField] in formcomponentValue
        if ($value) {
            return $value;
        }
        return null;
    }
}
