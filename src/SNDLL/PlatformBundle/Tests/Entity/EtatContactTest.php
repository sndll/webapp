<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\EtatContact;

class EtatContactTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $etatcontact = new EtatContact();

        $etatcontact->setId('1');
        $this->assertEquals('1', $etatcontact->getId());

        $etatcontact->setLibelle('Décédé');
        $this->assertEquals('Décédé', $etatcontact->getLibelle());
    }
}