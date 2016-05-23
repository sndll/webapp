<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Sacem;

class LoadSacemData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $sacem1 = new Sacem();
        $sacem1->setCodeSacem('70');
        $sacem1->setLibelle('Direction Régionale - Sud Ouest');
        $sacem1->setCoordonnees($this->getReference('Coordonnees-Sacem-Direction-Regional-Sud-Ouest'));
        $sacem1->setCivilite($this->getReference('Civilite-Monsieur'));
        $sacem1->setNomResponsable('Tankian');
        $sacem1->setPrenomResponsable('Serj');
        $sacem1->setDateDerniereModification(new \DateTime());

        $manager->persist($sacem1);

        $sacem2 = new Sacem();
        $sacem2->setCodeSacem('330');
        $sacem2->setLibelle('Délégation Régionnale - Sud Ouest');
        $sacem2->setCoordonnees($this->getReference('Coordonnees-Sacem-Delegation-Sud-Ouest'));
        $sacem2->setCivilite($this->getReference('Civilite-Monsieur'));
        $sacem2->setNomResponsable('Einaudi');
        $sacem2->setPrenomResponsable('Ludovico');
        $sacem2->setDateDerniereModification(new \DateTime());

        $manager->persist($sacem2);

        $manager->flush();

        $this->addReference('Sacem-Direction-Sud-Ouest', $sacem1);
        $this->addReference('Sacem-Delegation-Sud-Ouest', $sacem2);
    }

    public function getOrder()
    {
        return 3;
    }
}