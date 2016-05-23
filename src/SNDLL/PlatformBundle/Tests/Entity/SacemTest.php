<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Coordonnees;
use SNDLL\PlatformBundle\Entity\Sacem;
use SNDLL\PlatformBundle\Entity\Civilite;


class SacemTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $sacem = new Sacem();

        $sacem->setCodeSacem('200');
        $this->assertEquals('200', $sacem->getCodeSacem());

        $sacem->setLibelle('Direction National');
        $this->assertEquals('Direction National', $sacem->getLibelle());

        $coordonnees = new Coordonnees();
        $coordonnees->setAdresse('16 rue du test');
        $sacem->setCoordonnees($coordonnees);
        $this->assertEquals('16 rue du test', $sacem->getCoordonnees()->getAdresse());

        $civilite = new Civilite();
        $civilite->setLibelle('Monsieur');
        $sacem->setCivilite($civilite);
        $this->assertEquals('Monsieur', $sacem->getCivilite()->getLibelle());

        $sacem->setNomResponsable('Dillan');
        $this->assertEquals('Dillan', $sacem->getNomResponsable());

        $sacem->setPrenomResponsable('Boby');
        $this->assertEquals('Boby', $sacem->getPrenomResponsable());

        $sacem->setDateDerniereModification('2015-01-01');
        $this->assertEquals('2015-01-01', $sacem->getDateDerniereModification());
    }
}