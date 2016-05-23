<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CotisationPageTest extends WebTestCase
{
    private $em;

    private $listeCotisations;
    private $listeEtablissements;
    private $listeTypesAdhesions;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->setListeCotisations();
        $this->setListeEtablissements();
        $this->setListeTypesAdhesions();
    }

    public function setListeCotisations()
    {
        $this->listeCotisations = $this->em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisations();
    }

    public function setListeEtablissements()
    {
        $this->listeEtablissements = $this->em
            ->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements();
    }

    public function setListeTypesAdhesions()
    {
        $this->listeTypesAdhesions = $this->em
            ->getRepository('SNDLLPlatformBundle:TypeAdhesion')
            ->getTypesAdhesions();
    }

    public function testCodePageCotisationIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/cot');
		$this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}

	public function testCodePageCotisationView()
	{
        foreach ($this->listeCotisations as $cotisation) {
            $client = static::createClient();
            $crawler = $client->request('GET', '/cot/info/'.$cotisation->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de la cotisation : " . $cotisation->getId());
        }
	}

    public function testCodePageCotisationAdd()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cot/add');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCotisationAddWithEtablissement()
    {
        foreach ($this->listeEtablissements as $etablissement)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/cot/add/'.$etablissement->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
        }
    }

	public function testCodePageCotisationEdit()
	{
        foreach ($this->listeCotisations as $cotisation)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/cot/edit/'.$cotisation->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de la cotisation : " . $cotisation->getId());
        }
	}

	public function testCodePageCotisationDelete()
	{
        foreach ($this->listeCotisations as $cotisation)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/cot/del/'.$cotisation->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de la cotisation : " . $cotisation->getId());
        }
	}

    public function testCodePageTypeAdhesionIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cot/ta');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageTypeAdhesionAdd()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cot/ta/add');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageTypeAdhesionDelete()
    {
        foreach ($this->listeTypesAdhesions as $typeAdhesion)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/cot/ta/del/'.$typeAdhesion->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id du type d'adhésion : " . $typeAdhesion->getId());
        }
    }

    public function testCodePageFactureView()
    {
        foreach ($this->listeCotisations as $cotisation) {
            $client = static::createClient();
            $crawler = $client->request('GET', '/cot/view/facture/'.$cotisation->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de la cotisation : " . $cotisation->getId());
        }
    }

    public function testCodePageCotisationsJson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cot/json');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCotisationCertificatSacemView()
    {
        foreach ($this->listeCotisations as $cotisation)
        {
            $centreSacem = $cotisation->getAdherent()->getEtablissement()->getSacem();
            if ($centreSacem != null) {
                $client = static::createClient();
                $crawler = $client->request('GET', '/ogc/view/certificat/sacem/' . $cotisation->getId());
                $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de la cotisation : " . $cotisation->getId());
            }
        }
    }

    public function testCodePageCotisationCertificatSpreView()
    {
        foreach ($this->listeCotisations as $cotisation)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/ogc/view/certificat/spre/' . $cotisation->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de la cotisation : " . $cotisation->getId());
        }
    }
}
