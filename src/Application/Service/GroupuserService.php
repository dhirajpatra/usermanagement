<?php

namespace App\Application\Service;

use App\Domain\Model\Groupuser\Groupuser;
use App\Domain\Model\Groupuser\GroupuserRepositoryInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class GroupuserService
 * @package App\Application\Service
 */
class GroupuserService
{
    /**
     * @var GroupuserRepositoryInterface
     */
    private $groupuserRepository;

    /**
     * GroupuserService constructor.
     * @param GroupuserRepositoryInterface $groupuserRepository
     */
    public function __construct(
        GroupuserRepositoryInterface $groupuserRepository
    ) {
        $this->groupuserRepository = $groupuserRepository;
    }

    /**
     * @param int $groupId
     * @return Groupuser
     * @throws EntityNotFoundException
     */
    public function getGroupuserByGroup(int $groupId): Groupuser
    {
        try {
            $groupuser = $this->groupuserRepository->findByGroupId($groupId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$groupuser) {
            throw new EntityNotFoundException('Groupuser with groupid '.$groupId.' does not exist!');
        }
        return $groupuser;
    }

    /**
     * @param int $userId
     * @return bool
     * @throws EntityNotFoundException
     */
    public function getGroupuserByUser(int $userId): bool
    {
        try {
            $groupuser = $this->groupuserRepository->findByUserId($userId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$groupuser) {
            throw new EntityNotFoundException('Groupuser with userid '.$userId.' does not exist!');
        }

        return true;
    }

    /**
     * @param int $groupId
     * @return bool
     * @throws EntityNotFoundException
     */
    public function deleteGroupuserByGroup(int $groupId): bool
    {
        try {
            $groupuser = $this->groupuserRepository->findByGroupId($groupId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (empty($groupuser)) {
            $result = $this->groupRepository->delete($groupuser);
        } else {
            throw new EntityNotFoundException('Groupuser not deleted!');
        }

        return true;
    }

    /**
     * @param int $userId
     * @return bool
     * @throws EntityNotFoundException
     */
    public function deleteGroupuserByUser(int $userId): bool
    {
        try {
            $result = $this->groupuserRepository->delete($userId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if(!$result) {
            throw new EntityNotFoundException('Groupuser not deleted!');
        }

        return true;
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @param $groupuser
     * @return bool
     * @throws EntityNotFoundException
     */
    public function saveGroupuser(int $userId, int $groupId, $groupuser): bool
    {
        // checking if group and user exist
        $group =$this->groupuserRepository->getGroup($groupId);
        $user =$this->groupuserRepository->getGroup($userId);

        if($group && $user) {
            $result = $this->groupuserRepository->duplicateCheck($userId, $groupId);
           
            if (empty($result)) {
                $result = $this->groupuserRepository->save($groupuser);
            }else{
                throw new BadCredentialsException('Duplicate group user');
            }

        } else {
            throw new EntityNotFoundException('Group or user not found!');
        }

        if (!$result) {
            throw new EntityNotFoundException('Groupuser not saved!');
        }

        return true;
    }

}