<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\EtatEtablissement;

class EtatEtablissementTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $etatetablissement = new EtatEtablissement();

        $etatetablissement->setId('1');
        $this->assertEquals('1', $etatetablissement->getId());

        $etatetablissement->setLibelle('Ouvert');
        $this->assertEquals('Ouvert', $etatetablissement->getLibelle());
    }
}