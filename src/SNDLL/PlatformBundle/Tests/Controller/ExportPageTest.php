<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExportPageTest extends WebTestCase
{
    public function testCodePageEtablissementsExportAll()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/export/all');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageEtablissementsExportActuellementAdherents()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/export/with_cotisation');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageEtablissementsExportActuellementNonAdherents()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/export/without_cotisation');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCoordonneesAppelCotisationAnneeEnCours()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/export/appel/anneeencours');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCoordonneesAppelCotisationAnneeProchaine()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/export/appel/anneeprochaine');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCotisationsExportAll()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cot/export/all');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCotisationsExportEnCours()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cot/export/encours');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }
}
