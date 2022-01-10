<?php

declare(strict_types=1);

namespace PoP\Root\Component;

abstract class AbstractComponentAppState implements AppStateProviderInterface
{
    public function __construct(
        protected ComponentInterface $component
    ) {
    }

    public function augment(array &$state): void
    {
    }
}
