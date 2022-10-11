<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\FeedbackItemProviders;

use PoP\Root\FeedbackItemProviders\AbstractFeedbackItemProvider;
use PoP\Root\Feedback\FeedbackCategories;

class CheckpointErrorFeedbackItemProvider extends AbstractFeedbackItemProvider
{
    public final const E1 = '1';

    /**
     * @return string[]
     */
    public function getCodes(): array
    {
        return [
            self::E1,
        ];
    }

    public function getMessagePlaceholder(string $code): string
    {
        return match ($code) {
            self::E1 => $this->__('This field is to be accessed internally by the plugin only', 'graphql-api'),
            default => parent::getMessagePlaceholder($code),
        };
    }

    public function getCategory(string $code): string
    {
        return FeedbackCategories::ERROR;
    }
}
