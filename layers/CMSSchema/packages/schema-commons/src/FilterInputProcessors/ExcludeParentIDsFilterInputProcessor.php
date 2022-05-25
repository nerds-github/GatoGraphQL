<?php

declare(strict_types=1);

namespace PoPCMSSchema\SchemaCommons\FilterInputProcessors;

use PoP\ComponentModel\FilterInputProcessors\AbstractValueToQueryFilterInputProcessor;

class ExcludeParentIDsFilterInputProcessor extends AbstractValueToQueryFilterInputProcessor
{
    protected function getQueryArgKey(array $filterInput): string
    {
        return 'exclude-parent-ids';
    }
}
