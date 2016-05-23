<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\TypeAdhesion;

class LoadTypeAdhesionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type_adhesion1 = new TypeAdhesion();
        $type_adhesion1->setLibelle('Adhésion de base');
        $manager->persist($type_adhesion1);

        $type_adhesion2 = new TypeAdhesion();
        $type_adhesion2->setLibelle('Adhésion tous services');
        $manager->persist($type_adhesion2);

        $type_adhesion3 = new TypeAdhesion();
        $type_adhesion3->setLibelle('Ancienne adhésion');
        $manager->persist($type_adhesion3);

        $manager->flush();

        $this->addReference('TypeAdhesion-Base', $type_adhesion1);
        $this->addReference('TypeAdhesion-Premium', $type_adhesion2);
        $this->addReference('TypeAdhesion-Ancienne', $type_adhesion3);
    }

    public function getOrder()
    {
        return 1;
    }
}