<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OGCPageTest extends WebTestCase
{
    private $em;

    private $listeSacem;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->setListeSacem();
    }

    public function setListeSacem()
    {
        $this->listeSacem = $this->em
            ->getRepository('SNDLLPlatformBundle:Sacem')
            ->getCentresSacem();
    }

	public function testCodePageSacemIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/ogc/sacem');
		$this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}

    public function testCodePageSacemSelect()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ogc/sacem/select/1');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

	public function testCodePageSacemAdd()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/ogc/sacem/add');
		$this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}

	public function testCodePageSacemView()
	{
        foreach ($this->listeSacem as $sacem)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/ogc/sacem/info/' . $sacem->getCodeSacem());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id du centre Sacem : " . $sacem->getCodeSacem());
        }
	}

	public function testCodePageSacemEdit()
	{
        foreach ($this->listeSacem as $sacem)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/ogc/sacem/edit/' . $sacem->getCodeSacem());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id du centre Sacem : " . $sacem->getCodeSacem());
        }
	}

	public function testCodePageSacemDelete()
	{
        foreach ($this->listeSacem as $sacem)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/ogc/sacem/delete/' . $sacem->getCodeSacem());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id du centre Sacem : " . $sacem->getCodeSacem());
        }
	}

	public function testCodePageSpreView()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/ogc/spre/info');
		$this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}

	public function testCodePageSpreEdit()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/ogc/spre/edit');
		$this->assertTrue(200 === $client->getResponse()->getStatusCode());
	}
}
