<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPI\Unit\Faker;

use GraphQLByPoP\GraphQLServer\Unit\DisabledFixtureQueryExecutionGraphQLServerTestCaseTrait;

class DisabledExposeCoreFunctionalityWPFakerFixtureQueryExecutionGraphQLServerTest extends AbstractExposeCoreFunctionalityWPFakerFixtureQueryExecutionGraphQLServerTest
{
    use DisabledFixtureQueryExecutionGraphQLServerTestCaseTrait;
}