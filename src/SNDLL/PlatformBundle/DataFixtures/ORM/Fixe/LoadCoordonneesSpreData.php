<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Coordonnees;

class LoadCoordonneesSpreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $coordonnees1 = new Coordonnees();
        $coordonnees1->setAdresse('61 rue La Fayette');
        $coordonnees1->setCodePostal('75009');
        $coordonnees1->setVille('PARIS');
        $coordonnees1->setTelephonePrincipal('0153208700');
        $coordonnees1->setFax('0153208701');
        $manager->persist($coordonnees1);

        $manager->flush();

        $this->addReference('Coordonnees-Spre', $coordonnees1);
    }

    public function getOrder()
    {
        return 2;
    }
}