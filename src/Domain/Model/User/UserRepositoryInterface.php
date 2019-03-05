<?php

namespace App\Domain\Model\User;
/**
 * Interface UserRepositoryInterface
 * @package App\Domain\Model\User
 */
interface UserRepositoryInterface
{
    /**
     * @param int $userId
     * @return User
     */
    public function findById(int $userId): ? User;

    /**
     * @param string $username
     * @return array
     */
    public function findByName(string $username): ? array;

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool;

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool;

    /**
     * @param int $userId
     * @return array
     */
    public function getGroupuser(int $userId): array;

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteGroupuser(int $userId): bool;
}