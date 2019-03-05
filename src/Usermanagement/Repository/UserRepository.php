<?php

namespace App\Usermanagement\Repository;

use App\Domain\Model\Groupuser\Groupuser;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Cache\Persister\Collection;
use Doctrine\ORM\AbstractQuery;

/**
 * Class UserRepository
 * @package App\Usermanagement\Repository
 */
final class UserRepository implements UserRepositoryInterface
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
     * UserRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(User::class);
        $this->queryBuilder = $this->entityManager->createQueryBuilder();
    }
    
    /**
     * @param int $userId
     * @return User
     */
    public function findById(int $userId): ? User
    {
        try{
            return $this->objectRepository->find($userId);

        } catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param string $username
     * @return array
     */
    public function findByName(string $username): ? array
    {
        try {
            $result = $this->queryBuilder->select('u.id, u.username, u.status')
                ->from(User::class, 'u')
                ->where(
                    $this->queryBuilder->expr()->eq('u.username', "'" . $username . "'")
                )->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);
        }  catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        return $result;
    }

    /**
     * @param App\Domain\Model\User\User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }  catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        try {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }  catch(\Doctrine\ORM\ORMException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * This will find out whether there are any associated user in groupusers table for this user
     * @param int $userId
     * @return array
     */
    public function getGroupuser(int $userId): array
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
     * @return array
     */
    public function deleteGroupuser(int $userId): bool
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