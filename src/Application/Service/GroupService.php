<?php

namespace App\Application\Service;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class GroupService
 * @package App\Application\Service
 */
class GroupService
{
    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * UserService constructor.
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(
        GroupRepositoryInterface $groupRepository
    ) {
        $this->groupRepository = $groupRepository;
    }

    /**
     * @param int $groupId
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getGroup(int $groupId): Group
    {
        try {
            $group = $this->groupRepository->findById($groupId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$group) {
            throw new EntityNotFoundException('Group with id '.$groupId.' does not exist!');
        }
        return $group;
    }

    /**
     * @param string $groupname
     * @return Group
     * @throws EntityNotFoundException
     */
    public function getGroupByName(string $groupname): Group
    {
        try {
            $group = $this->groupRepository->findByName($groupname);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$group) {
            throw new EntityNotFoundException('Group with name '.$groupname.' does not exist!');
        }
        return $group;
    }

    /**
     * @param int $groupId
     * @return bool
     * @throws EntityNotFoundException
     */
    public function deleteGroup(int $groupId): bool
    {
        try {
            $group = $this->groupRepository->findById($groupId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$group) {
            throw new EntityNotFoundException('Group with id '.$groupId.' does not exist!');
        }

        try {
            // need to check if this group is still associated with any user or not
            $groupuser = $this->groupRepository->getGroupuser($groupId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!empty($groupuser)) {
            throw new EntityNotFoundException('Group with associated users exist cant delete!');
        }

        try {
            $result = $this->groupRepository->delete($group);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if (!$result) {
            throw new EntityNotFoundException('Group not deleted!');
        }

        return true;
    }

    /**
     * @param Group $group
     * @return bool
     * @throws EntityNotFoundException
     * @throws UniqueConstraintViolationException
     */
    public function saveGroup(Group $group): bool
    {
        try {
            $result = $this->groupRepository->findByName($group->getGroupname());

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }
        
        if (empty($result)) {
            $group = $this->groupRepository->save($group);
        }else{
            throw new BadCredentialsException('Duplicate group name');
        }

        if (!$group) {
            throw new EntityNotFoundException(' not saved!');
        }

        return true;
    }
    
}