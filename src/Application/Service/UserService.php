<?php

namespace App\Application\Service;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
/**
 * Class UserService
 * @package App\Application\Service
 */
class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUser(int $userId): User
    {
        try {
            $user = $this->userRepository->findById($userId);
        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$userId.' does not exist!');
        }
        return $user;
    }

    /**
     * @param int $userId
     * @return bool
     * @throws EntityNotFoundException
     */
    public function deleteUser(int $userId): bool
    {

        $user = $this->userRepository->findById($userId);

        if ($user === NULL) {
            throw new EntityNotFoundException('User with id ' . $userId . ' does not exist!');
        }

        // need to check if this user is still associated with any group or not
        $groupuser = $this->userRepository->getGroupuser($userId);
        if (!empty($groupuser)) {
            $result = $this->userRepository->deleteGroupuser($userId);
            if (!$result) {
                throw new EntityNotFoundException('GroupUser not deleted!');
            }
        }

        $result = $this->userRepository->delete($user);

        if (!$result) {
            throw new EntityNotFoundException('User not deleted!');
        }

        return true;
    }

    /**
     * @param User $user
     * @return bool
     * @throws EntityNotFoundException
     * @throws BadCredentialsException
     */
    public function saveUser(User $user): bool
    {
        
        $result = $this->userRepository->findByName($user->getUsername());

        if (empty($result)) {
            $user = $this->userRepository->save($user);
        }else{
            throw new BadCredentialsException('Duplicate user name');
        }

        if (!$user) {
            throw new EntityNotFoundException('User not saved!');
        }

        return true;
    }
}