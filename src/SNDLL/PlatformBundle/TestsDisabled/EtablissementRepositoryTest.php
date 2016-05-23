<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtablissementRepositoryTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testFind()
    {
        $etablissement = $this->em
            ->getRepository('SNDLLPlatformBundle:Etablissement')
            ->find(1)
        ;

        $this->assertEquals('Le Mega', $etablissement->getEnseigne());
    }

    public function testFindByEnseigne()
    {
        $etablissements = $this->em
            ->getRepository('SNDLLPlatformBundle:Etablissement')
            ->findByEnseigne('Le Mega')
        ;

        $this->assertEquals('Le Mega SARL', $etablissements[0]->getNomJuridique());
    }

    public function testFindAll()
    {
        $etablissements = $this->em
            ->getRepository('SNDLLPlatformBundle:Etablissement')
            ->findAll()
        ;

        $this->assertEquals('Le Mega', $etablissements[0]->getEnseigne());
        $this->assertEquals('330012015', $etablissements[0]->getAdherent()->getCodeAdherent());
        $this->assertEquals('SARL', $etablissements[0]->getFormeJuridique()->getLibelle());
        $this->assertEquals('16 rue des platanes', $etablissements[0]->getCoordonnees()->getAdresse());
        $this->assertEquals('9329Z', $etablissements[0]->getCodeAPE()->getCodeAPE());
        $this->assertEquals('entre 701 et 1500', $etablissements[0]->getCapacite()->getLibelle());
        $this->assertEquals('Ouvert', $etablissements[0]->getEtatEtablissement()->getLibelle());
        $this->assertEquals('330', $etablissements[0]->getSacem()->getCodeSacem());
        $this->assertEquals('Le Respublica', $etablissements[1]->getEnseigne());
    }
}