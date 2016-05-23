<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Coordonnees;
use SNDLL\PlatformBundle\Entity\Cotisation;
use SNDLL\PlatformBundle\Entity\Adherent;
use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\TypeAdhesion;
use SNDLL\PlatformBundle\Entity\ModeReglement;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CotisationTest extends WebTestCase
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
        $cotisation = new Cotisation();

        $cotisation->setId('1');
        $this->assertEquals('1', $cotisation->getId());

        $coordonnees = new Coordonnees();
        $coordonnees->setCodePostal(33740);
        $etablissement = new Etablissement();
        $etablissement->setCoordonnees($coordonnees);
        $adherent = new Adherent($this->em, $etablissement);
        $adherent->setCodeAdherent('330012005');
        $cotisation->setAdherent($adherent);
        $this->assertEquals('330012005', $cotisation->getAdherent()->getCodeAdherent());
        
        $type_adhesion = new TypeAdhesion();
        $type_adhesion->setLibelle('Adhésion de base');
        $cotisation->setTypeAdhesion($type_adhesion);
        $this->assertEquals('Adhésion de base', $cotisation->getTypeAdhesion()->getLibelle());

        $cotisation->setPrixCotisationTTC('116.68');
        $this->assertEquals('116.68', $cotisation->getPrixCotisationTTC());

        $mode_reglement = new ModeReglement();
        $mode_reglement->setLibelle('Chèque');
        $cotisation->setModeReglement($mode_reglement);
        $this->assertEquals('Chèque', $cotisation->getModeReglement()->getLibelle());

        $cotisation->setDateDebut('2014-01-01');
        $this->assertEquals('2014-01-01', $cotisation->getDateDebut());

        $cotisation->setDateFin('2014-12-31');
        $this->assertEquals('2014-12-31', $cotisation->getDateFin());

        $cotisation->setDateReglement('2014-01-31');
        $this->assertEquals('2014-01-31', $cotisation->getDateReglement());
    }
}