<?php

declare(strict_types=1);

namespace PHPUnitForGatoGraphQL\WPFakerSchema\Unit;

use GraphQLByPoP\GraphQLServer\Unit\EnabledDisabledFixtureQueryExecutionGraphQLServerTestCaseTrait;

abstract class AbstractEnableDisableWPFakerFixtureQueryExecutionGraphQLServerTestCase extends AbstractWPFakerFixtureQueryExecutionGraphQLServerTestCase
{
    use EnabledDisabledFixtureQueryExecutionGraphQLServerTestCaseTrait;
}
