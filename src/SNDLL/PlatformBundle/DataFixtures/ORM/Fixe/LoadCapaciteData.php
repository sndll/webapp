<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Capacite;

class LoadCapaciteData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $capacite1 = new Capacite();
        $capacite1->setLibelle('Inconnu');
        $manager->persist($capacite1);

        $capacite2 = new Capacite();
        $capacite2->setLibelle('inférieure à 120');
        $manager->persist($capacite2);

        $capacite3 = new Capacite();
        $capacite3->setLibelle('entre 121 et 300');
        $manager->persist($capacite3);

        $capacite4 = new Capacite();
        $capacite4->setLibelle('entre 301 et 700');
        $manager->persist($capacite4);

        $capacite5 = new Capacite();
        $capacite5->setLibelle('entre 701 et 1500');
        $manager->persist($capacite5);

        $capacite6 = new Capacite();
        $capacite6->setLibelle('supérieur à 1500');
        $manager->persist($capacite6);

        $manager->flush();

        $this->addReference('Capacite-Inconnu', $capacite1);
        $this->addReference('Très-Faible', $capacite2);
        $this->addReference('Faible', $capacite3);
        $this->addReference('Moyenne', $capacite4);
        $this->addReference('Grande', $capacite5);
        $this->addReference('Très-Grande', $capacite6);
    }

    public function getOrder()
    {
        return 1;
    }
}