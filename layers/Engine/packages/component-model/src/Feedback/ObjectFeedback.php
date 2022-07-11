<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Feedback;

use PoP\ComponentModel\Engine\EngineIterationFieldSet;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\AstInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\Directive;
use PoP\Root\Feedback\FeedbackItemResolution;

/**
 * The ObjectFeedback is used to store errors that happen during
 * a directive pipeline stage. The `$astNode` is where the error
 * happens, and the `$directive` is the Directive executing that
 * stage on the pipeline.
 */
class ObjectFeedback extends AbstractQueryFeedback implements ObjectFeedbackInterface
{
    /**
     * @param AstInterface $astNode AST node where the error happens (eg: an Argument inside the Directive)
     * @param Directive $directive At what stage from the Directive pipeline does the error happen
     * @param @var array<string|int,EngineIterationFieldSet> $idFieldSet
     * @param @var array<string, mixed> $extensions
     */
    public function __construct(
        FeedbackItemResolution $feedbackItemResolution,
        AstInterface $astNode,
        protected Directive $directive,
        protected RelationalTypeResolverInterface $relationalTypeResolver,
        protected array $idFieldSet,
        array $extensions = [],
    ) {
        parent::__construct(
            $feedbackItemResolution,
            $astNode,
            $extensions,
        );
    }

    /**
     * @var array<string|int,EngineIterationFieldSet> $idFieldSet
     */
    public static function fromObjectTypeFieldResolutionFeedback(
        ObjectTypeFieldResolutionFeedbackInterface $objectTypeFieldResolutionFeedback,
        RelationalTypeResolverInterface $relationalTypeResolver,
        array $idFieldSet,
    ): self {
        return new self(
            $objectTypeFieldResolutionFeedback->getFeedbackItemResolution(),
            $objectTypeFieldResolutionFeedback->getAstNode(),
            $objectTypeFieldResolutionFeedback->getDirective(),
            $relationalTypeResolver,
            $idFieldSet,
            $objectTypeFieldResolutionFeedback->getExtensions(),
        );
    }

    public function getDirective(): Directive
    {
        return $this->directive;
    }

    public function getRelationalTypeResolver(): RelationalTypeResolverInterface
    {
        return $this->relationalTypeResolver;
    }

    /**
     * @return array<string|int,EngineIterationFieldSet>
     */
    public function getIDFieldSet(): array
    {
        return $this->idFieldSet;
    }
}
