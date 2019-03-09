<?php

namespace App\DataFixtures;

use App\Domain\Model\Groupuser\Groupuser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GroupuserFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $groupUser = new Groupuser();

        $group = $this->getReference(GroupFixtures::FIXTURE_GROUP1);
        $user = $this->getReference(UserFixtures::FIXTURE_USER1);

        $groupUser->setUserid($user->getId());
        $groupUser->setGroupid($group->getId());

        $manager->persist($groupUser);

        $manager->flush();

        $groupUser = new Groupuser();

        $group = $this->getReference(GroupFixtures::FIXTURE_GROUP2);
        $user = $this->getReference(UserFixtures::FIXTURE_USER2);

        $groupUser->setUserid($user->getId());
        $groupUser->setGroupid($group->getId());

        $manager->persist($groupUser);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            GroupFixtures::class
        );
    }
}
