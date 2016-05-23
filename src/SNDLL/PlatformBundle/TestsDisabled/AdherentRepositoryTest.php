<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdherentRepositoryTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testCodeAdherentExisteDeja()
    {
        $codeAdherent = 330012015;
        $retour = $this->em
            ->getRepository('SNDLLPlatformBundle:Adherent')
            ->codeAdherentExisteDeja($codeAdherent)
        ;
        $this->assertTrue($retour);

        $codeAdherent = 339992015;
        $retour = $this->em
            ->getRepository('SNDLLPlatformBundle:Adherent')
            ->codeAdherentExisteDeja($codeAdherent)
        ;
        $this->assertFalse($retour);
    }
}