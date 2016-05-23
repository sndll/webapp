<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypeAdhesionRepositoryTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetTypesAdhesions()
    {
        $listeTypesAdhesions= $this->em
            ->getRepository('SNDLLPlatformBundle:TypeAdhesion')
            ->getTypesAdhesions()
        ;

        $this->assertEquals('Adhésion de base', $listeTypesAdhesions[0]->getLibelle());
    }
}