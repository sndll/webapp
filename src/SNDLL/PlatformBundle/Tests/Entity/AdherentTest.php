<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Coordonnees;
use SNDLL\PlatformBundle\Entity\Adherent;
use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\EtatCotisation;
use SNDLL\PlatformBundle\Entity\Cotisation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdherentTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetterSetter()
    {
        $coordonnees = new Coordonnees();
        $coordonnees->setCodePostal(66000);
        $etablissement = new Etablissement();
        $etablissement->setCoordonnees($coordonnees);
        $adherent = new Adherent($this->em, $etablissement);

        $adherent->setId('1');
        $this->assertEquals('1', $adherent->getId());

        $adherent->setCodeAdherent('750421984');
        $this->assertEquals('750421984', $adherent->getCodeAdherent());

        $cotisation = new Cotisation();
        $cotisation->setPrixCotisationTTC(460);
        $adherent->addCotisation($cotisation);
        $liste_cotisations = $adherent->getCotisations();
        $this->assertEquals('460', $liste_cotisations[0]->getPrixCotisationTTC());
        $adherent->removeCotisation($cotisation);
        $liste_cotisations = $adherent->getCotisations();
        $this->assertCount(0, $liste_cotisations);

        $etablissement = new Etablissement();
        $etablissement->setEnseigne('Megamacumba');
        $adherent->setEtablissement($etablissement);
        $etablissement_recupere = $adherent->getEtablissement();
        $this->assertEquals('Megamacumba', $etablissement_recupere->getEnseigne());

        $adherent->setDatePremiereCotisation('1980-01-01');
        $this->assertEquals('1980-01-01', $adherent->getDatePremiereCotisation());

        $adherent->setIdDerniereCotisation(1);
        $this->assertEquals(1, $adherent->getIdDerniereCotisation());

        $adherent->setDateDerniereModification('2015-01-01');
        $this->assertEquals('2015-01-01', $adherent->getDateDerniereModification());
    }

    public function testGenerationCodeAdherent()
    {
        $coordonnees = new Coordonnees();
        $coordonnees->setCodePostal(66000);

        $etablissement = new Etablissement();
        $etablissement->setCoordonnees($coordonnees);

        $adherent = new Adherent($this->em, $etablissement);
        $this->assertEquals('660012015', $adherent->getCodeAdherent());
    }
}