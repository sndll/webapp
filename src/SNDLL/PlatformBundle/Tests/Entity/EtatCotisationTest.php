<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\EtatCotisation;

class EtatCotisationTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $etatcotisation = new EtatCotisation();

        $etatcotisation->setId('1');
        $this->assertEquals('1', $etatcotisation->getId());

        $etatcotisation->setLibelle('A jour');
        $this->assertEquals('A jour', $etatcotisation->getLibelle());
    }
}