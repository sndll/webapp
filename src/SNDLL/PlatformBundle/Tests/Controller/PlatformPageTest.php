<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlatformPageTest extends WebTestCase
{
    public function testCodePagePlatform()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/stats');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageCarteAdherentsVilles()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/carte/adherents/villes');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageChart1Json()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/chart1JsonData');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageChart2Json()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/chart2JsonData');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageChart3Json()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/chart3JsonData');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageChart4Json()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/chart4JsonData');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }

    public function testCodePageChart5Json()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/chart5JsonData');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());

    }
}