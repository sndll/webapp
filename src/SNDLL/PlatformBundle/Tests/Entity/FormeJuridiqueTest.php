<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\FormeJuridique;

class FormeJuridiqueTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $formejuridique = new FormeJuridique();

        $formejuridique->setId('1');
        $this->assertEquals('1', $formejuridique->getId());

        $formejuridique->setLibelle('SARL');
        $this->assertEquals('SARL', $formejuridique->getLibelle());
    }
}