<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Capacite;

class CapaciteTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $capacite = new Capacite();

        $capacite->setId('1');
        $this->assertEquals('1', $capacite->getId());

        $capacite->setLibelle('De 100 à 1000 personnes');
        $this->assertEquals('De 100 à 1000 personnes', $capacite->getLibelle());
    }
}