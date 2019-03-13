<?php

namespace App\Usermanagement\Repository;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Group\GroupRepositoryInterface;
use App\Domain\Model\Groupuser\Groupuser;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Cache\Persister\Collection;
use Doctrine\ORM\AbstractQuery;
/**
 * Class GroupRepository
 * @package App\Usermanagement\Repository
 */
final class GroupRepository implements GroupRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    /**
     * @var $queryBuilder
     */
    private $queryBuilder;

    /**
     * GroupRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Group::class);
        $this->queryBuilder = $this->entityManager->createQueryBuilder();
    }

    /**
     * @param int $groupId
     * @return Group
     */
    public function findById(int $groupId): ? Group
    {
       return $this->objectRepository->find($groupId);

    }

    /**
     * @param string $groupname
     * @return array
     */
    public function findByName(string $groupname): ? array
    {
        try {
            $result = $this->queryBuilder->select('g.id, g.groupname, g.status')
                ->from(Group::class, 'g')
                ->where(
                    $this->queryBuilder->expr()->eq('g.groupname', "'" . $groupname . "'")
                )->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);

        } catch(\Doctrine\ORM\ORMException $e) {
            return array();
        }
        
        return $result;
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function save(Group $group): bool
    {
        try {
            $this->entityManager->persist($group);
            $this->entityManager->flush();

        } catch(\Doctrine\ORM\ORMException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function delete(Group $group): bool
    {
        try {
            $this->entityManager->remove($group);
            $this->entityManager->flush();

        } catch(\Doctrine\ORM\ORMException $e) {
            return false;
        }

        return true;
    }

    /**
     * This will find out whether there are any associated user in groupusers table for this group
     * @param int $groupId
     * @return array
     */
    public function getGroupuser(int $groupId): array
    {
        try {
            $result = $this->queryBuilder->select('g.id, g.groupid, g.userid')
                ->from(Groupuser::class, 'g')
                ->where('g.groupid = ' . $groupId)
                ->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);

        } catch(\Doctrine\ORM\ORMException $e) {
            return array();
        }

        return $result;
    }
}