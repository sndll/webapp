<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CotisationRepositoryTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetCotisationsByEtablissement()
    {
        $etablissement = $this->em->getRepository('SNDLLPlatformBundle:Etablissement')->find(2);

        $cotisations = $this->em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisationsByEtablissement($etablissement, 5)
        ;

        $this->assertEquals('330022015', $cotisations[0]->getAdherent()->getCodeAdherent());
        $this->assertEquals('Adhésion tous services', $cotisations[0]->getTypeAdhesion()->getLibelle());
        $this->assertCount(5, $cotisations);
    }

    public function testGetCotisationEnCours()
    {
        $codeAdherent1 = 330012015;
        $cotisationRetournee = $this->em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisationEnCours($codeAdherent1)
        ;

        $this->assertEquals(1, count($cotisationRetournee));

        $codeAdherent2 = 330022015;
        $cotisationRetournee = $this->em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisationEnCours($codeAdherent2)
        ;
        $this->assertEquals(0, count($cotisationRetournee));
    }
}