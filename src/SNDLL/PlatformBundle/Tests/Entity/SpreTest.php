<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Civilite;
use SNDLL\PlatformBundle\Entity\Coordonnees;
use SNDLL\PlatformBundle\Entity\Spre;

class SpreTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $spre = new Spre();

        $spre->setId('1');
        $this->assertEquals('1', $spre->getId());

        $spre->setLibelle('Direction National');
        $this->assertEquals('Direction National', $spre->getLibelle());

        $coordonnees = new Coordonnees();
        $coordonnees->setAdresse('16 rue des platanes');
        $spre->setCoordonnees($coordonnees);
        $this->assertEquals('16 rue des platanes', $spre->getCoordonnees()->getAdresse());

        $civilite = new Civilite();
        $civilite->setLibelle('Monsieur');
        $spre->setCivilite($civilite);
        $this->assertEquals('Monsieur', $spre->getCivilite()->getLibelle());

        $spre->setNomResponsable('Dillan');
        $this->assertEquals('Dillan', $spre->getNomResponsable());

        $spre->setPrenomResponsable('Boby');
        $this->assertEquals('Boby', $spre->getPrenomResponsable());

        $spre->setDateDerniereModification('2015-01-01');
        $this->assertEquals('2015-01-01', $spre->getDateDerniereModification());
    }
}