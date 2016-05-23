<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\TypeAdhesion;

class TypeAdhesionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $typeadhesion = new TypeAdhesion();

        $typeadhesion->setId('1');
        $this->assertEquals('1', $typeadhesion->getId());

        $typeadhesion->setLibelle('Adhésion tous services');
        $this->assertEquals('Adhésion tous services', $typeadhesion->getLibelle());
    }
}