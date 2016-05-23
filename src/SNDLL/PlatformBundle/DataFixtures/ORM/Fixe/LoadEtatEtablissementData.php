<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\EtatEtablissement;

class LoadEtatEtablissementData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etat_etablissement1 = new EtatEtablissement();
        $etat_etablissement1->setLibelle('Inconnu');
        $manager->persist($etat_etablissement1);

        $etat_etablissement2 = new EtatEtablissement();
        $etat_etablissement2->setLibelle('Ouvert');
        $manager->persist($etat_etablissement2);

        $etat_etablissement3 = new EtatEtablissement();
        $etat_etablissement3->setLibelle('Fermeture Temporaire');
        $manager->persist($etat_etablissement3);

        $etat_etablissement4 = new EtatEtablissement();
        $etat_etablissement4->setLibelle('Fermeture Définitive');
        $manager->persist($etat_etablissement4);

        $manager->flush();

        $this->addReference('Inconnu', $etat_etablissement1);
        $this->addReference('Ouvert', $etat_etablissement2);
        $this->addReference('Fermeture-Temporaire', $etat_etablissement3);
        $this->addReference('Fermeture-Definitive', $etat_etablissement4);
    }

    public function getOrder()
    {
        return 1;
    }
}