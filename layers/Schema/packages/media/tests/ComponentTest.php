<?php

namespace PoPSchema\Media;

use PoP\Root\App;
use PoP\Engine\AbstractTestCase;

class ComponentTest extends AbstractTestCase
{
    /**
     * The component must have some dependency (only the root has not)
     */
    public function testHasDependedComponentClasses(): void
    {
        $this->assertNotEmpty(
            App::getComponent(Component::class)->getDependedComponentClasses()
        );
    }
}
