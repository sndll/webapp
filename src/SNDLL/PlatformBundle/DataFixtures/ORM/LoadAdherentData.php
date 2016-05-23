<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Adherent;

class LoadAdherentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adherent1 = new Adherent($manager, $this->getReference('Mega'));
        $adherent1->setDatePremiereCotisation(new \DateTime('2015-01-01'));
        $adherent1->setIdentifiants($this->getReference('identifiants1'));
        $adherent1->setIdDerniereCotisation(1);
        $adherent1->setDateDerniereModification(new \DateTime());

        $manager->persist($adherent1);

        $manager->flush();

        $adherent2 = new Adherent($manager, $this->getReference('Respublica'));
        $adherent2->setDatePremiereCotisation(new \DateTime('2010-06-01'));
        $adherent2->setIdentifiants($this->getReference('identifiants2'));
        $adherent2->setIdDerniereCotisation(6);
        $adherent2->setDateDerniereModification(new \DateTime());

        $manager->persist($adherent2);

        $manager->flush();
        
        $this->addReference('adherent1', $adherent1);
        $this->addReference('adherent2', $adherent2);
    }

    public function getOrder()
    {
        return 5;
    }
}