<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactPageTest extends WebTestCase
{
    private $em;

    private $listeContacts;

    private $listeEtablissements;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->setListeContacts();
        $this->setListeEtablissements();
    }

    public function setListeContacts()
    {
        $this->listeContacts = $this->em
            ->getRepository('SNDLLPlatformBundle:Contact')
            ->getContacts();
    }

    public function setListeEtablissements()
    {
        $this->listeEtablissements = $this->em
            ->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements();
    }

    public function testCodePageContactAdd()
    {
        foreach ($this->listeEtablissements as $etablissement)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/con/add/' . $etablissement->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id de l'établissement : " . $etablissement->getId());
        }
    }
    public function testCodePageContactEdit()
    {
        foreach ($this->listeContacts as $contact)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/con/edit/' . $contact->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id du contact : " . $contact->getId());
        }
    }
    public function testCodePageContactDelete()
    {
        foreach ($this->listeContacts as $contact)
        {
            $client = static::createClient();
            $crawler = $client->request('GET', '/con/delete/' . $contact->getId());
            $this->assertTrue(200 === $client->getResponse()->getStatusCode(), "Id du contact : " . $contact->getId());
        }
    }
}
