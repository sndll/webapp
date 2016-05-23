<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\EtatCotisation;

class LoadEtatCotisationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etat_cotisation1 = new EtatCotisation();
        $etat_cotisation1->setLibelle('Cotisation à jour');
        $manager->persist($etat_cotisation1);

        $etat_cotisation2 = new EtatCotisation();
        $etat_cotisation2->setLibelle('En attente de cotisation');
        $manager->persist($etat_cotisation2);

        $etat_cotisation3 = new EtatCotisation();
        $etat_cotisation3->setLibelle('Non adhérent');
        $manager->persist($etat_cotisation3);        

        $manager->flush();

        $this->addReference('A-Jour', $etat_cotisation1);
        $this->addReference('En-Attente', $etat_cotisation2);
        $this->addReference('Non-Adherent', $etat_cotisation3);
    }

    public function getOrder()
    {
        return 1;
    }
}