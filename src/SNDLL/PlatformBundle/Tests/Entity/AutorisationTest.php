<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Autorisation;

class AutorisationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $autorisation = new Autorisation();

        $autorisation->setId('1');
        $this->assertEquals('1', $autorisation->getId());

        $autorisation->setLibelle('Newsletter Uniquement');
        $this->assertEquals('Newsletter Uniquement', $autorisation->getLibelle());
    }
}