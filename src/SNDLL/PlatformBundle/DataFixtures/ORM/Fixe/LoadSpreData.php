<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Spre;

class LoadSpreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $spre = new Spre();
        $spre->setLibelle('Direction National');
        $spre->setCoordonnees($this->getReference('Coordonnees-Spre'));
        $spre->setCivilite($this->getReference('Civilite-Madame'));
        $spre->setNomResponsable('KALESKI');
        $spre->setPrenomResponsable('Nathalie');
        $spre->setDateDerniereModification(new \DateTime());

        $manager->persist($spre);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}