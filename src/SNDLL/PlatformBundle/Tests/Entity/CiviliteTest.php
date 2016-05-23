<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Civilite;

class CiviliteTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $civilite = new Civilite();

        $civilite->setId('1');
        $this->assertEquals('1', $civilite->getId());

        $civilite->setLibelle('Monsieur');
        $this->assertEquals('Monsieur', $civilite->getLibelle());
    }
}