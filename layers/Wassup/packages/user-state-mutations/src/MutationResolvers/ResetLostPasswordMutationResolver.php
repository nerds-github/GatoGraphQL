<?php

declare(strict_types=1);

namespace PoPSitesWassup\UserStateMutations\MutationResolvers;

use PoP\ComponentModel\Mutation\MutationDataProviderInterface;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoP\ComponentModel\MutationResolvers\ErrorTypes;
use PoP\Root\App;
use PoP\Root\Exception\AbstractException;
use PoP\Root\Exception\GenericClientException;
use PoP\UserAccount\FunctionAPIFactory;
use PoPCMSSchema\Users\TypeAPIs\UserTypeAPIInterface;
use PoPSitesWassup\UserStateMutations\MutationResolverUtils\MutationResolverUtils;

class ResetLostPasswordMutationResolver extends AbstractMutationResolver
{
    private ?UserTypeAPIInterface $userTypeAPI = null;

    final public function setUserTypeAPI(UserTypeAPIInterface $userTypeAPI): void
    {
        $this->userTypeAPI = $userTypeAPI;
    }
    final protected function getUserTypeAPI(): UserTypeAPIInterface
    {
        return $this->userTypeAPI ??= $this->instanceManager->getInstance(UserTypeAPIInterface::class);
    }

    public function getErrorType(): int
    {
        return ErrorTypes::CODES;
    }

    public function validateErrors(MutationDataProviderInterface $mutationDataProvider): array
    {
        $errorcodes = array();
        $code = $mutationDataProvider->getValue(MutationInputProperties::CODE);
        $pwd = $mutationDataProvider->getValue(MutationInputProperties::PASSWORD);
        $repeatpwd = $mutationDataProvider->getValue(MutationInputProperties::REPEAT_PASSWORD);

        if (!$code) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errorcodes[] = 'error-nocode';
        }
        if (!$pwd) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errorcodes[] = 'error-nopwd';
        } elseif (strlen($pwd) < 8) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errorcodes[] = 'error-short';
        }
        if (!$repeatpwd) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errorcodes[] = 'error-norepeatpwd';
        }
        if ($pwd != $repeatpwd) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errorcodes[] = 'error-pwdnomatch';
        }
        return $errorcodes;
    }
    /**
     * @throws AbstractException In case of error
     */
    public function executeMutation(MutationDataProviderInterface $mutationDataProvider): mixed
    {
        $code = $mutationDataProvider->getValue(MutationInputProperties::CODE);
        $pwd = $mutationDataProvider->getValue(MutationInputProperties::PASSWORD);

        $cmsuseraccountapi = FunctionAPIFactory::getInstance();
        $decoded = MutationResolverUtils::decodeLostPasswordCode($code);
        $rp_key = $decoded['key'];
        $rp_login = $decoded['login'];

        if (!$rp_key || !$rp_login) {
            throw new GenericClientException($this->__('Wrong code', ''));
        }
        $user = $cmsuseraccountapi->checkPasswordResetKey($rp_key, $rp_login);

        // Do the actual password reset
        $cmsuseraccountapi->resetPassword($user, $pwd);

        $userID = $this->getUserTypeAPI()->getUserID($user);
        App::doAction('gd_lostpasswordreset', $userID);
        return $userID;
    }
}
