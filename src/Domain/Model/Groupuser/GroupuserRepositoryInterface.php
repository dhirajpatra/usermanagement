<?php

namespace App\Domain\Model\Groupuser;
use App\Domain\Model\Group\Group;

/**
 * Interface GroupuserRepositoryInterface
 * @package App\Domain\Model\Groupuser
 */
interface GroupuserRepositoryInterface
{
    /**
     * This will check/fetch if that groupid has any user or record
     * @param int $groupId
     * @return array
     */
    public function findByGroupId(int $groupId): array;

    /**
     * This will check/fetch if that userid has any group or record
     * @param int $userId
     * @return array
     */
    public function findByUserId(int $userId): array;

    /**
     * @param int $userId
     * @param int $groupId
     * @return array
     */
    public function duplicateCheck(int $userId, int $groupId): array;

    /**
     * This will assign a user to a group
     * @param Groupuser $groupuser
     * @return bool
     */
    public function save(Groupuser $groupuser): bool;

    /**
     * This will remove a user from a group
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool;

    /**
     * group exist of not
     * @param $groupId
     * @return bool
     */
    public function getGroup(int $groupId) : bool;

    /**
     * user exist or not
     * @param int $userId
     * @return bool
     */
    public function getUser(int $userId) : bool;
}