<?php

declare(strict_types=1);

namespace PoPSchema\LocationPosts\Conditional\Users;

use PoPSchema\LocationPosts\Component;
use PoP\Root\Component\InitializeContainerServicesInComponentTrait;

/**
 * Initialize component
 */
class ConditionalComponent
{
    use InitializeContainerServicesInComponentTrait;

    public static function initialize(
        array $configuration = [],
        bool $skipSchema = false,
        array $skipSchemaComponentClasses = []
    ): void {
        self::maybeInitYAMLSchemaServices(Component::$COMPONENT_DIR, $skipSchema, '/Conditional/Users');
    }
}
