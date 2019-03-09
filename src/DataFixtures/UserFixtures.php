<?php

namespace App\DataFixtures;

use App\Domain\Model\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("FixtureUser");
        $user->setStatus(1);
        $manager->persist($user);

        $manager->flush();
    }
}
