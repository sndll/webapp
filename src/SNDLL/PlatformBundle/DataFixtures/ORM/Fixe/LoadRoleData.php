<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role1 = new Role();
        $role1->setLibelle('Inconnu');
        $manager->persist($role1);

        $role2 = new Role();
        $role2->setLibelle('Responsable');
        $manager->persist($role2);

        $role3 = new Role();
        $role3->setLibelle('Comptable');
        $manager->persist($role3);

        $role4 = new Role();
        $role4->setLibelle('Avocat');
        $manager->persist($role4);
        
        $role5 = new Role();
        $role5->setLibelle('Autre');
        $manager->persist($role5);

        $manager->flush();

        $this->addReference('Role-Inconnu', $role1);
        $this->addReference('Role-Responsable', $role2);
        $this->addReference('Role-Comptable', $role3);
        $this->addReference('Role-vocat', $role4);
        $this->addReference('Role-Autre', $role5);
    }

    public function getOrder()
    {
        return 1;
    }
}