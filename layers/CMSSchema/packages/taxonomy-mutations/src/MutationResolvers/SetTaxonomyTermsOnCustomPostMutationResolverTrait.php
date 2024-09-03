<?php

declare(strict_types=1);

namespace PoPCMSSchema\TaxonomyMutations\MutationResolvers;

use PoPCMSSchema\Taxonomies\Facades\TaxonomyTermTypeAPIFacade;
use PoPCMSSchema\Taxonomies\TypeAPIs\TaxonomyTermTypeAPIInterface;
use PoPCMSSchema\TaxonomyMutations\Constants\MutationInputProperties;
use PoPCMSSchema\TaxonomyMutations\FeedbackItemProviders\MutationErrorFeedbackItemProvider;
use PoP\ComponentModel\Feedback\FeedbackItemResolution;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedback;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;

trait SetTaxonomyTermsOnCustomPostMutationResolverTrait
{
    use MutateTaxonomyTermMutationResolverTrait;
    
    /**
     * Retrieve the taxonomy from the queried entites.
     * If the taxonomy is explicitly provided, validate that the
     * entities indeed have that taxonomy.
     */
    protected function getTaxonomyToTaxonomyTermsByID(
        array $taxonomyTermIDs,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): ?array {
        /** @var string|null */
        $taxonomyName = $fieldDataAccessor->getValue(MutationInputProperties::TAXONOMY);
        if ($taxonomyName !== null) {
            $errorCount = $objectTypeFieldResolutionFeedbackStore->getErrorCount();

            foreach ($taxonomyTermIDs as $taxonomyTermID) {
                $this->validateTaxonomyTermByIDExists(
                    $taxonomyTermID,
                    $taxonomyName,
                    $fieldDataAccessor,
                    $objectTypeFieldResolutionFeedbackStore,
                );
            }

            if ($objectTypeFieldResolutionFeedbackStore->getErrorCount() > $errorCount) {
                return null;
            }

            return [
                $taxonomyName => $taxonomyTermIDs,
            ];
        }

        $errorCount = $objectTypeFieldResolutionFeedbackStore->getErrorCount();

        // Retrieve the taxonomy from the terms
        $taxonomyToTaxonomyTermsIDs = [];
        $taxonomyTermTypeAPI = $this->getTaxonomyTermTypeAPI();
        foreach ($taxonomyTermIDs as $taxonomyTermID) {
            $taxonomyName = $taxonomyTermTypeAPI->getTaxonomyTermTaxonomy($taxonomyTermID);
            if ($taxonomyName === null) {
                $objectTypeFieldResolutionFeedbackStore->addError(
                    new ObjectTypeFieldResolutionFeedback(
                        $this->getTaxonomyTermDoesNotExistError($taxonomyName, $taxonomyTermID),
                        $fieldDataAccessor->getField(),
                    )
                );
                continue;
            }
            $taxonomyToTaxonomyTermsIDs[$taxonomyName] ??= [];
            $taxonomyToTaxonomyTermsIDs[$taxonomyName][] = $taxonomyTermID;
        }

        if ($objectTypeFieldResolutionFeedbackStore->getErrorCount() > $errorCount) {
            return null;
        }

        return $taxonomyToTaxonomyTermsIDs;
    }

    /**
     * Retrieve the taxonomy from the queried entites.
     * If the taxonomy is explicitly provided, validate that the
     * entities indeed have that taxonomy.
     *
     * @return array<string,array<string|int>>|null
     */
    protected function getTaxonomyToTaxonomyTermsBySlug(
        array $taxonomyTermSlugs,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): ?array {
        /** @var string|null */
        $taxonomyName = $fieldDataAccessor->getValue(MutationInputProperties::TAXONOMY);
        if ($taxonomyName !== null) {
            $taxonomyToTaxonomyTermsIDs = [
                $taxonomyName => [],
            ];
            
            $errorCount = $objectTypeFieldResolutionFeedbackStore->getErrorCount();

            foreach ($taxonomyTermSlugs as $taxonomyTermSlug) {
                $taxonomyTermID = $this->getTaxonomyTermTypeAPI()->getTaxonomyTermID($taxonomyTermSlug, $taxonomyName);
                if ($taxonomyTermID === null) {
                    $objectTypeFieldResolutionFeedbackStore->addError(
                        new ObjectTypeFieldResolutionFeedback(
                            $this->getTaxonomyTermBySlugDoesNotExistError($taxonomyName, $taxonomyTermSlug),
                            $fieldDataAccessor->getField(),
                        )
                    );
                    continue;
                }
                $taxonomyToTaxonomyTermsIDs[$taxonomyName][] = $taxonomyTermID;
            }

            if ($objectTypeFieldResolutionFeedbackStore->getErrorCount() > $errorCount) {
                return null;
            }

            return $taxonomyToTaxonomyTermsIDs;
        }

        $errorCount = $objectTypeFieldResolutionFeedbackStore->getErrorCount();

        // Retrieve the taxonomy from the terms
        $taxonomyToTaxonomyTermsIDs = [];
        $taxonomyTermTypeAPI = $this->getTaxonomyTermTypeAPI();
        foreach ($taxonomyTermSlugs as $taxonomyTermSlug) {
            $taxonomyTermID = $taxonomyTermTypeAPI->getTaxonomyTermID($taxonomyTermSlug);
            if ($taxonomyTermID === null) {
                $objectTypeFieldResolutionFeedbackStore->addError(
                    new ObjectTypeFieldResolutionFeedback(
                        $this->getTaxonomyTermBySlugDoesNotExistError(null, $taxonomyTermSlug),
                        $fieldDataAccessor->getField(),
                    )
                );
                continue;
            }
            /** @var string */
            $taxonomyName = $taxonomyTermTypeAPI->getTaxonomyTermTaxonomy($taxonomyTermID);
            $taxonomyToTaxonomyTermsIDs[$taxonomyName] ??= [];
            $taxonomyToTaxonomyTermsIDs[$taxonomyName][] = $taxonomyTermID;
        }

        if ($objectTypeFieldResolutionFeedbackStore->getErrorCount() > $errorCount) {
            return null;
        }

        return $taxonomyToTaxonomyTermsIDs;
    }

    protected function getTaxonomyTermTypeAPI(): TaxonomyTermTypeAPIInterface
    {
        return TaxonomyTermTypeAPIFacade::getInstance();
    }

    /**
     * Retrieve the taxonomy passed via the `taxonomy` input.
     * If that's not possible (eg: on `createCustomPost:input.categoriesBy`),
     * then retrieve it from queried object's CPT.
     */
    protected function validateTaxonomyIsRegisteredForCustomPost(
        string|int $customPostID,
        string $taxonomyName,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        $customPostType = $this->getCustomPostTypeAPI()->getCustomPostType($customPostID);
        if ($customPostType === null) {
            $objectTypeFieldResolutionFeedbackStore->addError(
                new ObjectTypeFieldResolutionFeedback(
                    new FeedbackItemResolution(
                        MutationErrorFeedbackItemProvider::class,
                        MutationErrorFeedbackItemProvider::E11,
                        [
                            $customPostID,
                        ]
                    ),
                    $fieldDataAccessor->getField(),
                )
            );
            return null;
        }

        $taxonomyNames = $this->getTaxonomyTermTypeAPI()->getCustomPostTypeTaxonomyNames($customPostType);
        if (in_array($taxonomyName, $taxonomyNames)) {
            return;
        }
        $objectTypeFieldResolutionFeedbackStore->addError(
            new ObjectTypeFieldResolutionFeedback(
                $this->getTaxonomyIsNotRegisteredInCustomPostTypeFeedbackItemResolution(
                    $taxonomyName,
                    $customPostType,
                ),
                $fieldDataAccessor->getField(),
            )
        );
    }

    protected function getTaxonomyIsNotRegisteredInCustomPostTypeFeedbackItemResolution(
        string $taxonomyName,
        string $customPostType,
    ): FeedbackItemResolution {
        return new FeedbackItemResolution(
            MutationErrorFeedbackItemProvider::class,
            MutationErrorFeedbackItemProvider::E12,
            [
                $taxonomyName,
                $customPostType,
            ]
        );
    }
}
