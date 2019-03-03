<?php

namespace App\Domain\Model\Group;
/**
 * Interface GroupRepositoryInterface
 * @package App\Domain\Model\Group
 */
interface GroupRepositoryInterface
{
    /**
     * @param int $groupId
     * @return Group
     */
    public function findById(int $groupId): ? Group;

    /**
     * @param string $groupname
     * @return array
     */
    public function findByName(string $groupname): ? array;

    /**
     * @param Group $group
     * @return bool
     */
    public function save(Group $group): bool;

    /**
     * @param Group $group
     * @return bool
     */
    public function delete(Group $group): bool;

    /**
     * @param int $groupId
     * @return array
     */
    public function getGroupuser(int $groupId): array;
}