<?php

namespace App\DataFixtures;

use App\Domain\Model\Groupuser\Groupuser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GroupuserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $groupUser = new Groupuser();
        $manager->persist($groupUser);

        $manager->flush();
    }
}
