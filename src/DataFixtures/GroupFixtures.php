<?php

namespace App\DataFixtures;

use App\Domain\Model\Group\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setGroupname("FixtureGroup");
        $group->setStatus(1);
        $manager->persist($group);

        $manager->flush();
    }
}
