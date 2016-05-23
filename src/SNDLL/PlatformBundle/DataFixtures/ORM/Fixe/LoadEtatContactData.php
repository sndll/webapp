<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\EtatContact;

class LoadEtatContactData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etat_contact1 = new EtatContact();
        $etat_contact1->setLibelle('Inconnu');
        $manager->persist($etat_contact1);

        $etat_contact2 = new EtatContact();
        $etat_contact2->setLibelle('Actif');
        $manager->persist($etat_contact2);

        $etat_contact3 = new EtatContact();
        $etat_contact3->setLibelle('Inactif Temporaire');
        $manager->persist($etat_contact3);

        $etat_contact4 = new EtatContact();
        $etat_contact4->setLibelle('Inactif Définitivement');
        $manager->persist($etat_contact4);

        $manager->flush();

        $this->addReference('EtatContact-Inconnu', $etat_contact1);
        $this->addReference('EtatContact-Actif', $etat_contact2);
        $this->addReference('EtatContact-Inactif-Temporaire', $etat_contact3);
        $this->addReference('EtatContact-Inactif-Definitivement', $etat_contact4);
    }

    public function getOrder()
    {
        return 1;
    }
}