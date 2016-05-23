<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\ModeReglement;

class ModeReglementTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $modereglement = new ModeReglement();

        $modereglement->setId('1');
        $this->assertEquals('1', $modereglement->getId());

        $modereglement->setLibelle('Chèque');
        $this->assertEquals('Chèque', $modereglement->getLibelle());
    }
}