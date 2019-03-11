<?php

namespace App\DataFixtures;

use App\Domain\Model\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const FIXTURE_USER1 = "FixtureUser1";
    public const FIXTURE_USER2 = "FixtureUser2";

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("FixtureUser1");
        $user->setStatus(1);
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::FIXTURE_USER1, $user);

        $user = new User();
        $user->setUsername("FixtureUser2");
        $user->setStatus(1);
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::FIXTURE_USER2, $user);
    }

}
