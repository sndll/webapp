<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtablissementPageTest extends WebTestCase
{
    private $em;

    private $listeEtablissements;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->setListeEtablissements();
    }

    public function setListeEtablissements()
    {
        $this->listeEtablissements = $this->em
            ->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements();
    }

	public function testCodePageEtablissementIndex()
	{
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}

	public function testCodePageEtablissementView()
	{
        foreach ($this->listeEtablissements as $etablissement)
        {
		    $client = static::createClient();
		    $crawler = $client->request('GET', '/eta/info/'.$etablissement->getId());
		    $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
        }
	}

	public function testCodePageEtablissementAdd()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/eta/add');
		$this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}

	public function testCodePageEtablissementEdit()
	{
        foreach ($this->listeEtablissements as $etablissement)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/eta/edit/' . $etablissement->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
        }
	}

	public function testCodePageEtablissementDelete()
	{
        foreach ($this->listeEtablissements as $etablissement)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/eta/del/'.$etablissement->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
        }
	}

    public function testCodePageEtablissementViewFicheRenseignement()
    {
        foreach ($this->listeEtablissements as $etablissement)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/eta/view/fiche/' . $etablissement->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
        }
    }

    public function testCodePageEtablissementJson()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/json');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageMajWordpress()
    {
        foreach ($this->listeEtablissements as $etablissement)
        {
            if ($etablissement->getAdherent() != null)
            {
                $client = static::createClient();
                $crawler = $client->request('GET', '/wp/maj/' . $etablissement->getAdherent()->getCodeAdherent());
                $this->assertTrue(302 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
            }
        }
    }

    public function testCodePageRenewPasswordWordpress()
    {
        foreach ($this->listeEtablissements as $etablissement)
        {
            if ($etablissement->getAdherent() != null AND $etablissement->getAdherent()->getIdentifiants() != null)
            {
                $client = static::createClient();
                $crawler = $client->request('GET', '/wp/renew/password/' . $etablissement->getAdherent()->getCodeAdherent());
                $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
            }
        }
    }
}
