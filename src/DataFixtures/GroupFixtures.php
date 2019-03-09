<?php

namespace App\DataFixtures;

use App\Domain\Model\Group\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;

class GroupFixtures extends Fixture
{
    public const FIXTURE_GROUP1 = "FixtureGroup1";
    public const FIXTURE_GROUP2 = "FixtureGroup2";

    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setGroupname("FixtureGroup1");
        $group->setStatus(1);
        $manager->persist($group);

        $manager->flush();
        $this->addReference(self::FIXTURE_GROUP1, $group);

        $group = new Group();
        $group->setGroupname("FixtureGroup2");
        $group->setStatus(1);
        $manager->persist($group);

        $manager->flush();
        $this->addReference(self::FIXTURE_GROUP2, $group);

    }

}
