<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Coordonnees;
use SNDLL\PlatformBundle\Entity\Autorisation;

class CoordonneesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $coordonnees = new Coordonnees();

        $coordonnees->setId('1');
        $this->assertEquals('1', $coordonnees->getId());

        $coordonnees->setAdresse('18 cours de Verdun');
        $this->assertEquals('18 cours de Verdun', $coordonnees->getAdresse());

        $coordonnees->setCodePostal('33470');
        $this->assertEquals('33470', $coordonnees->getCodePostal());

        $coordonnees->setVille('Gujan-Mestras');
        $this->assertEquals('Gujan-Mestras', $coordonnees->getVille());

        $coordonnees->setInformationsComplementaires("La rue à été renommée récémment (anciennement cours de Stalingrad)");
        $this->assertEquals('La rue à été renommée récémment (anciennement cours de Stalingrad)', $coordonnees->getInformationsComplementaires());

        $coordonnees->setTelephonePrincipal('0554332256');
        $this->assertEquals('0554332256', $coordonnees->getTelephonePrincipal());
            
        $coordonnees->setTelephoneSecondaire('0654332256');
        $this->assertEquals('0654332256', $coordonnees->getTelephoneSecondaire());

        $coordonnees->setFax('0554332257');
        $this->assertEquals('0554332257', $coordonnees->getFax());

        $coordonnees->setEmail('service-info@sndll.org');
        $this->assertEquals('service-info@sndll.org', $coordonnees->getEmail());

        $autorisation = new Autorisation();
        $autorisation->setLibelle('Urgences seulement');
        $coordonnees->setAutorisation($autorisation);
        $this->assertEquals('Urgences seulement', $coordonnees->getAutorisation()->getLibelle());
    }
}