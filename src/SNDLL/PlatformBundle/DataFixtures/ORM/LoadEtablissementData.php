<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Etablissement;

class LoadEtablissementData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etablissement1 = new Etablissement();
        $etablissement1->setEnseigne('Le Mega');
        $etablissement1->setFormejuridique($this->getReference('FJ-SARL'));
        $etablissement1->setNomJuridique('Le Mega SARL');
        $etablissement1->setCoordonnees($this->getReference('Coordonnees-Mega-Etablissement'));
        $etablissement1->setSiteInternet('www.lemega.fr');
        $etablissement1->setCodeAPE($this->getReference('9329Z'));
        $etablissement1->setCodeSIRET('303277206');
        $etablissement1->setDateCreation(new \DateTime('2014-01-01'));
        $etablissement1->setCapacite($this->getReference('Grande'));
        $etablissement1->setNombreSalaries(12);
        $etablissement1->setCommentaires("Cet établissement est renommé pour ses repas...");
        $etablissement1->setEtatEtablissement($this->getReference('Ouvert'));
        $etablissement1->setSacem($this->getReference('Sacem-Delegation-Sud-Ouest'));
        $etablissement1->setDateDerniereModification(new \DateTime());
        
        $manager->persist($etablissement1);

        $etablissement2 = new Etablissement();
        $etablissement2->setEnseigne('Le Respublica');
        $etablissement2->setFormejuridique($this->getReference('FJ-Entreprise-Individuelle'));
        $etablissement2->setNomJuridique('Le Respublica Complexe');
        $etablissement2->setCoordonnees($this->getReference('Coordonnees-Respublica-Etablissement'));
        $etablissement2->setSiteInternet('www.lerespublica-bordeaux.fr');
        $etablissement2->setCodeAPE($this->getReference('5630Z'));
        $etablissement2->setCodeSIRET('303277205');
        $etablissement2->setDateCreation(new \DateTime('2010-06-01'));
        $etablissement2->setCapacite($this->getReference('Très-Faible'));
        $etablissement2->setNombreSalaries(102);
        $etablissement2->setCommentaires("Ancien bar le meltdown");
        $etablissement2->setEtatEtablissement($this->getReference('Fermeture-Temporaire'));
        $etablissement2->setSacem($this->getReference('Sacem-Delegation-Sud-Ouest'));
        $etablissement2->setDateDerniereModification(new \DateTime());

        $manager->persist($etablissement2);

        $manager->flush();

        $this->addReference('Mega', $etablissement1);
        $this->addReference('Respublica', $etablissement2);
    }

    public function getOrder()
    {
        return 4;
    }
}