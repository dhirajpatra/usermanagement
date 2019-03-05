<?php

namespace App\Usermanagement\Repository;

use App\Domain\Model\Group\Group;
use App\Domain\Model\Groupuser\Groupuser;
use App\Domain\Model\Groupuser\GroupuserRepositoryInterface;
use App\Domain\Model\User\User;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Cache\Persister\Collection;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use App\Usermanagement\Repository\GroupRepository;
use App\Usermanagement\Repository\UserRepository;

/**
 * Class GroupuserRepository
 * @package App\Usermanagement\Repository
 */
final class GroupuserRepository implements GroupuserRepositoryInterface
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
     * GroupuserRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Groupuser::class);
        $this->queryBuilder = $this->entityManager->createQueryBuilder();
    }

    /**
     * @param int $groupId
     * @return array
     */
    public function findByGroupId(int $groupId): array
    {
        try {
            $result = $this->queryBuilder->select('g.id, g.groupid, g.userid')
                ->from(Groupuser::class, 'g')
                ->where('g.groupid = ' . $groupId)
                ->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        return $result;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function findByUserId(int $userId): array
    {
        try {
            $result = $this->queryBuilder->select('g.id, g.groupid, g.userid')
                ->from(Groupuser::class, 'g')
                ->where('g.userid = ' . $userId)
                ->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        return $result;
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @return array
     */
    public function duplicateCheck(int $userId, int $groupId): array
    {

        $result = $this->queryBuilder->select('g.id, g.groupid, g.userid')
            ->from(Groupuser::class, 'g')
            ->where("g.userid = :user")->setParameter("user", $userId)
            ->andWhere("g.groupid = :group")->setParameter("group", $groupId)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        return $result;
    }

    /**
     * @param \App\Domain\Model\Groupuser\Groupuser $groupuser
     * @return bool
     */
    public function save(Groupuser $groupuser): bool
    {
        try {
            $this->entityManager->persist($groupuser);
            $this->entityManager->flush();

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool
    {
        try {
            $result = $this->queryBuilder->delete(Groupuser::class, 'g')
                ->where("g.userid = :user")->setParameter("user", $userId)
                ->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        if($result){
            return true;
        }

        return false;
    }

    /**
     * @param int $groupId [this need to implement]
     * @return bool
     */
    public function getGroup(int $groupId) : bool
    {

        $result = $this->queryBuilder->select('u.id, g.id')
            ->from(Groupuser::class, 'u')
            ->innerJoin(Group::class, 'g', 'u.groupid = g.id')
            ->where('u.groupid = :groupid')
            ->setParameter('groupid', $groupId)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        if($result){
            return true;
        }

        return false;
    }

    /**
     * user exist or not [this need to implement]
     * @param int $userId
     * @return bool
     */
    public function getUser(int $userId) : bool
    {
        $result = $this->queryBuilder->select('g.id')
            ->from(Groupuser::class, 'g')
            ->innerJoin('g.userid', 'u', 'WITH', 'u.id = :userid')
            ->where('g.userid = :userid')
            ->setParameter('userid', $userId)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        if($result){
            return true;
        }

        return false;
    }

}