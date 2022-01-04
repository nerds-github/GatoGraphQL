<?php

namespace PoP\EmojiDefinitions;

use PoP\Root\AbstractTestCase;

class ComponentTest extends AbstractTestCase
{
    /**
     * The component must have some dependency (only the root has not)
     */
    public function testHasDependedComponentClasses(): void
    {
        $this->assertNotEmpty(
            \PoP\Root\Managers\ComponentManager::getComponent(Component::class)->getDependedComponentClasses()
        );
    }
}
