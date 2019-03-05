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

}