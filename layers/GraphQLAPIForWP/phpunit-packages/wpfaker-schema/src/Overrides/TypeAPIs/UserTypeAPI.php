<?php

declare(strict_types=1);

namespace GraphQLAPI\WPFakerSchema\Overrides\TypeAPIs;

use GraphQLAPI\WPFakerSchema\App;
use GraphQLAPI\WPFakerSchema\Component;
use GraphQLAPI\WPFakerSchema\ComponentConfiguration;
use GraphQLAPI\WPFakerSchema\DataProvider\DataProviderInterface;
use GraphQLAPI\WPFakerSchema\Overrides\TypeAPIs\TypeAPITrait;
use PoPCMSSchema\UsersWP\TypeAPIs\UserTypeAPI as UpstreamUserTypeAPI;
use WP_User;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
class UserTypeAPI extends UpstreamUserTypeAPI
{
    use TypeAPITrait;

    private ?DataProviderInterface $dataProvider = null;

    final public function setDataProvider(DataProviderInterface $dataProvider): void
    {
        $this->dataProvider = $dataProvider;
    }
    final protected function getDataProvider(): DataProviderInterface
    {
        return $this->dataProvider ??= $this->instanceManager->getInstance(DataProviderInterface::class);
    }

    protected function resolveGetUsers(array $query): array
    {
        /** @var ComponentConfiguration */
        $componentConfiguration = App::getComponent(Component::class)->getConfiguration();
        $useFixedDataset = $componentConfiguration->useFixedDataset();

        $retrieveUserIDs = $this->retrieveUserIDs($query);

        /**
         * If providing the IDs to retrieve, re-generate exactly those objects.
         */
        $ids = $query['include'] ?? null;
        if (!empty($ids)) {
            /** @var int[] */
            $userIDs = is_string($ids) ? array_map(
                fn (string $id) => (int) trim($id),
                explode(',', $ids)
            ) : $ids;
            /**
             * If using a fixed dataset, make sure the ID exists.
             * If it does not, return `null` instead
             */
            if ($useFixedDataset) {
                $userIDs = array_values(array_intersect(
                    $userIDs,
                    $this->getFakeUserIDs()
                ));
            }
            if ($retrieveUserIDs) {
                return $userIDs;
            }
            return $useFixedDataset
                ? $this->getFakeUsers($userIDs)
                : array_map(
                    fn (string|int $id) => App::getWPFaker()->user([
                        // The ID is provided, the rest is random data
                        'id' => $id
                    ]),
                    $userIDs
                );
        }

        /**
         * Get users from the fixed dataset?
         */
        if ($useFixedDataset) {
            $userDataEntries = $this->getFakeUserDataEntries();
            if (isset($query['login'])) {
                $userDataEntries = $this->filterUserDataEntriesByProperty(
                    $userDataEntries,
                    'login',
                    $query['login']
                );
            }
            $userDataEntries = array_slice(
                $userDataEntries,
                $query['offset'] ?? 0,
                $query['number'] ?? 10
            );
            $userIDs = array_map(
                fn (array $userDataEntry): int => $userDataEntry['id'],
                $userDataEntries,
            );
            if ($retrieveUserIDs) {
                return $userIDs;
            }
            return $this->getFakeUsers($userIDs);
        }

        /**
         * Otherwise, let BrainFaker produce random entries
         */
        $users = App::getWPFaker()->users($query['number'] ?? 10);
        if ($retrieveUserIDs) {
            return array_map(
                fn (WP_User $user) => $user->ID,
                $users
            );
        }
        return $users;
    }

    protected function retrieveUserIDs(array $query): bool
    {
        return ($query['fields'] ?? null) === 'ID';
    }

    /**
     * @param int[] $userIDs
     * @return WP_User[]
     */
    protected function getFakeUsers(array $userIDs): array
    {
        return array_map(
            fn (array $fakeUserDataEntry) => App::getWPFaker()->user($fakeUserDataEntry),
            $this->getFakeUserDataEntries($userIDs)
        );
    }

    /**
     * @return int[] $userIDs
     */
    protected function getFakeUserIDs(): array
    {
        return array_values(array_map(
            fn (array $userDataEntry) => (int) $userDataEntry['author_id'],
            $this->getAllFakeUserDataEntries()
        ));
    }

    /**
     * @return array<array<string,mixed>>
     */
    protected function getAllFakeUserDataEntries(): array
    {
        return $this->getDataProvider()->getFixedDataset()['authors'] ?? [];
    }

    /**
     * @param int[] $userIDs
     * @return array<string,mixed>
     */
    protected function getFakeUserDataEntries(?array $userIDs = null): array
    {
        if ($userIDs === []) {
            return [];
        }
        $userDataEntries = $this->getAllFakeUserDataEntries();
        if ($userIDs !== null) {
            $userDataEntries = array_filter(
                $userDataEntries,
                fn (array $userDataEntry) => in_array($userDataEntry['author_id'], $userIDs)
            );
        }
        return array_map(
            fn (array $userDataEntry) => [
                'id' => $userDataEntry['author_id'],
                'login' => $userDataEntry['author_login'],
                'email' => $userDataEntry['author_email'],
                'display_name' => $userDataEntry['author_display_name'],
                'first_name' => $userDataEntry['author_first_name'],
                'last_name' => $userDataEntry['author_last_name'],
            ],
            $userDataEntries
        );
    }

    protected function resolveGetUserBy(string $property, string | int $propertyValue): WP_User|false
    {
        /** @var ComponentConfiguration */
        $componentConfiguration = App::getComponent(Component::class)->getConfiguration();
        $useFixedDataset = $componentConfiguration->useFixedDataset();

        if ($useFixedDataset) {
            /**
             * Get the data of all users matching the passed property
             */
            $userDataEntries = $this->filterUserDataEntriesByProperty(
                $this->getFakeUserDataEntries(),
                $property,
                $propertyValue
            );
            if ($userDataEntries === []) {
                return false;
            }
            $userID = $userDataEntries[0]['id'];
            $users = $this->getFakeUsers([$userID]);
            return $users[0];
        }

        return App::getWPFaker()->user([
            // Whatever data was provided, mirror it back in a random new user
            $property => $propertyValue
        ]);
    }

    protected function filterUserDataEntriesByProperty(array $userDataEntries, string $property, string|int|array $propertyValueOrValues): array
    {
        $propertyValues = is_array($propertyValueOrValues) ? $propertyValueOrValues : [$propertyValueOrValues];
        return array_values(array_filter(array_map(
            fn (array $fakeUserDataEntry): ?array => in_array($fakeUserDataEntry[$property] ?? null, $propertyValues) ? $fakeUserDataEntry : null,
            $userDataEntries,
        )));
    }
}
