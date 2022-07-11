<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Feedback;

use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\AstInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\Directive;
use PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface;
use PoP\Root\Feedback\FeedbackItemResolution;

class ObjectFeedback extends AbstractQueryFeedback implements ObjectFeedbackInterface
{
    public function __construct(
        FeedbackItemResolution $feedbackItemResolution,
        AstInterface $astNode,
        protected RelationalTypeResolverInterface $relationalTypeResolver,
        protected string|int $objectID,
        /** @var array<string, mixed> */
        array $extensions = [],
        /** @var ObjectFeedbackInterface[] */
        protected array $nested = [],
    ) {
        parent::__construct(
            $feedbackItemResolution,
            $astNode,
            $extensions,
        );
    }

    public static function fromObjectTypeFieldResolutionFeedback(
        ObjectTypeFieldResolutionFeedbackInterface $objectTypeFieldResolutionFeedback,
        RelationalTypeResolverInterface $relationalTypeResolver,
        FieldInterface $field,
        string|int $objectID,
        ?Directive $directive
    ): self {
        /** @var ObjectFeedbackInterface[] */
        $nestedObjectFeedbackEntries = [];
        foreach ($objectTypeFieldResolutionFeedback->getNested() as $nestedObjectTypeFieldResolutionFeedback) {
            $nestedObjectFeedbackEntries[] = static::fromObjectTypeFieldResolutionFeedback(
                $nestedObjectTypeFieldResolutionFeedback,
                $relationalTypeResolver,
                $field,
                $objectID,
                $directive
            );
        }
        return new self(
            $objectTypeFieldResolutionFeedback->getFeedbackItemResolution(),
            $objectTypeFieldResolutionFeedback->getAstNode(),
            $relationalTypeResolver,
            $objectID,
            $objectTypeFieldResolutionFeedback->getExtensions(),
            $nestedObjectFeedbackEntries
        );
    }

    public function getRelationalTypeResolver(): RelationalTypeResolverInterface
    {
        return $this->relationalTypeResolver;
    }

    public function getObjectID(): string|int
    {
        return $this->objectID;
    }

    /**
     * @return ObjectFeedbackInterface[]
     */
    public function getNested(): array
    {
        return $this->nested;
    }
}
