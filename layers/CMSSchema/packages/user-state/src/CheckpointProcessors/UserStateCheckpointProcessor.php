<?php

declare(strict_types=1);

namespace PoPCMSSchema\UserState\CheckpointProcessors;

use PoP\ComponentModel\Checkpoint\CheckpointError;
use PoP\ComponentModel\CheckpointProcessors\AbstractCheckpointProcessor;
use PoP\Root\App;
use PoPCMSSchema\UserState\FeedbackItemProviders\CheckpointErrorFeedbackItemProvider;

class UserStateCheckpointProcessor extends AbstractCheckpointProcessor
{
    public const USERLOGGEDIN = 'userloggedin';
    public const USERNOTLOGGEDIN = 'usernotloggedin';

    private ?CheckpointErrorFeedbackItemProvider $checkpointErrorFeedbackItemProvider = null;

    final public function setCheckpointErrorFeedbackItemProvider(CheckpointErrorFeedbackItemProvider $checkpointErrorFeedbackItemProvider): void
    {
        $this->checkpointErrorFeedbackItemProvider = $checkpointErrorFeedbackItemProvider;
    }
    final protected function getCheckpointErrorFeedbackItemProvider(): CheckpointErrorFeedbackItemProvider
    {
        return $this->checkpointErrorFeedbackItemProvider ??= $this->instanceManager->getInstance(CheckpointErrorFeedbackItemProvider::class);
    }

    public function getCheckpointsToProcess(): array
    {
        return array(
            [self::class, self::USERLOGGEDIN],
            [self::class, self::USERNOTLOGGEDIN],
        );
    }

    public function validateCheckpoint(array $checkpoint): ?CheckpointError
    {
        switch ($checkpoint[1]) {
            case self::USERLOGGEDIN:
                if (!App::getState('is-user-logged-in')) {
                    return new CheckpointError(
                        $this->getCheckpointErrorFeedbackItemProvider()->getMessage(CheckpointErrorFeedbackItemProvider::E1),
                        $this->getCheckpointErrorFeedbackItemProvider()->getNamespacedCode(CheckpointErrorFeedbackItemProvider::E1),
                    );
                }
                break;

            case self::USERNOTLOGGEDIN:
                if (App::getState('is-user-logged-in')) {
                    return new CheckpointError(
                        $this->getCheckpointErrorFeedbackItemProvider()->getMessage(CheckpointErrorFeedbackItemProvider::E2),
                        $this->getCheckpointErrorFeedbackItemProvider()->getNamespacedCode(CheckpointErrorFeedbackItemProvider::E2),
                    );
                }
                break;
        }

        return parent::validateCheckpoint($checkpoint);
    }
}
