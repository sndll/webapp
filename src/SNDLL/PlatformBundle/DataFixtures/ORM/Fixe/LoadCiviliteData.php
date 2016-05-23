<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Civilite;

class LoadCiviliteData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $civilite1 = new Civilite();
        $civilite1->setLibelle('Monsieur');
        $manager->persist($civilite1);

        $civilite2 = new Civilite();
        $civilite2->setLibelle('Madame');
        $manager->persist($civilite2);

        $manager->flush();

        $this->addReference('Civilite-Monsieur', $civilite1);
        $this->addReference('Civilite-Madame', $civilite2);
    }

    public function getOrder()
    {
        return 1;
    }
}