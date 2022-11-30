<?php

declare(strict_types=1);

namespace PoPCMSSchema\CustomPostMutations\MutationResolvers;

use PoPCMSSchema\CustomPostMutations\FeedbackItemProviders\MutationErrorFeedbackItemProvider;
use PoPCMSSchema\CustomPostMutations\LooseContracts\LooseContractSet;
use PoPCMSSchema\CustomPostMutations\TypeAPIs\CustomPostTypeMutationAPIInterface;
use PoPCMSSchema\CustomPosts\Enums\CustomPostStatus;
use PoPCMSSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPCMSSchema\UserRoles\TypeAPIs\UserRoleTypeAPIInterface;
use PoPCMSSchema\UserStateMutations\MutationResolvers\ValidateUserLoggedInMutationResolverTrait;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedback;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\LooseContracts\NameResolverInterface;
use PoP\Root\App;
use PoP\Root\Feedback\FeedbackItemResolution;

trait CreateUpdateCustomPostMutationResolverTrait
{
    use ValidateUserLoggedInMutationResolverTrait;

    abstract protected function getNameResolver(): NameResolverInterface;
    abstract protected function getUserRoleTypeAPI(): UserRoleTypeAPIInterface;
    abstract protected function getCustomPostTypeAPI(): CustomPostTypeAPIInterface;
    abstract protected function getCustomPostTypeMutationAPI(): CustomPostTypeMutationAPIInterface;

    protected function validateCanLoggedInUserCreateCustomPosts(
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        // Check that the user is logged-in
        $errorFeedbackItemResolution = $this->validateUserIsLoggedIn();
        if ($errorFeedbackItemResolution !== null) {
            $objectTypeFieldResolutionFeedbackStore->addError(
                new ObjectTypeFieldResolutionFeedback(
                    $errorFeedbackItemResolution,
                    $fieldDataAccessor->getField(),
                )
            );
            return;
        }

        // Validate user permission
        $userID = App::getState('current-user-id');
        $editCustomPostsCapability = $this->getNameResolver()->getName(LooseContractSet::NAME_EDIT_CUSTOMPOSTS_CAPABILITY);
        if (
            !$this->getUserRoleTypeAPI()->userCan(
                $userID,
                $editCustomPostsCapability
            )
        ) {
            $objectTypeFieldResolutionFeedbackStore->addError(
                new ObjectTypeFieldResolutionFeedback(
                    new FeedbackItemResolution(
                        MutationErrorFeedbackItemProvider::class,
                        MutationErrorFeedbackItemProvider::E2,
                    ),
                    $fieldDataAccessor->getField(),
                )
            );
            return;
        }

        // Check if the user can publish custom posts
        if ($fieldDataAccessor->getValue(MutationInputProperties::STATUS) === CustomPostStatus::PUBLISH) {
            $publishCustomPostsCapability = $this->getNameResolver()->getName(LooseContractSet::NAME_PUBLISH_CUSTOMPOSTS_CAPABILITY);
            if (
                !$this->getUserRoleTypeAPI()->userCan(
                    $userID,
                    $publishCustomPostsCapability
                )
            ) {
                $objectTypeFieldResolutionFeedbackStore->addError(
                    new ObjectTypeFieldResolutionFeedback(
                        new FeedbackItemResolution(
                            MutationErrorFeedbackItemProvider::class,
                            MutationErrorFeedbackItemProvider::E3,
                        ),
                        $fieldDataAccessor->getField(),
                    )
                );
            }
        }
    }

    protected function getUserNotLoggedInError(): FeedbackItemResolution
    {
        return new FeedbackItemResolution(
            MutationErrorFeedbackItemProvider::class,
            MutationErrorFeedbackItemProvider::E1,
        );
    }

    protected function validateCustomPostExists(
        string|int|null $customPostID,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        if (!$customPostID) {
            $objectTypeFieldResolutionFeedbackStore->addError(
                new ObjectTypeFieldResolutionFeedback(
                    new FeedbackItemResolution(
                        MutationErrorFeedbackItemProvider::class,
                        MutationErrorFeedbackItemProvider::E6,
                    ),
                    $fieldDataAccessor->getField(),
                )
            );
            return;
        }

        if (!$this->getCustomPostTypeAPI()->customPostExists($customPostID)) {
            $objectTypeFieldResolutionFeedbackStore->addError(
                new ObjectTypeFieldResolutionFeedback(
                    new FeedbackItemResolution(
                        MutationErrorFeedbackItemProvider::class,
                        MutationErrorFeedbackItemProvider::E7,
                        [
                            $customPostID,
                        ]
                    ),
                    $fieldDataAccessor->getField(),
                )
            );
        }
    }

    protected function validateCanLoggedInUserEditCustomPost(
        string|int $customPostID,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        // Check that the user has access to the edited custom post
        $userID = App::getState('current-user-id');
        if (!$this->getCustomPostTypeMutationAPI()->canUserEditCustomPost($userID, $customPostID)) {
            $objectTypeFieldResolutionFeedbackStore->addError(
                new ObjectTypeFieldResolutionFeedback(
                    new FeedbackItemResolution(
                        MutationErrorFeedbackItemProvider::class,
                        MutationErrorFeedbackItemProvider::E8,
                        [
                            $customPostID,
                        ]
                    ),
                    $fieldDataAccessor->getField(),
                )
            );
        }
    }
}
