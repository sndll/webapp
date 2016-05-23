<?php

namespace SNDLL\PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtablissementAddPageTest extends WebTestCase
{
    public function testListeDeroulanteCodeAPE()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/add');
        $expectedcontent = "#\<option value=\"Inconnu\">Inconnu</option><option value=\"Autre\">Autre</option><option value=\"9329Z\">9329Z</option><option value=\"5630Z\">5630Z</option></select>#";
        $pagecontent = $client->getResponse()->getContent();
        if (preg_match($expectedcontent, $pagecontent))
        {
            $this->assertTrue(True);
        }
        else
        {
            $this->assertTrue(False);
        }
    }

    public function testListeDeroulanteCapacite()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/eta/add');
        $expectedcontent = "#\<option value=\"1\">Inconnu</option><option value=\"2\">inférieure à 120</option><option value=\"3\">entre 121 et 300</option><option value=\"4\">entre 301 et 700</option><option value=\"5\">entre 701 et 1500</option><option value=\"6\">supérieur à 1500</option></select>#";
        $pagecontent = $client->getResponse()->getContent();
        if (preg_match($expectedcontent, $pagecontent))
        {
            $this->assertTrue(True);
        }
        else
        {
            $this->assertTrue(False);
        }
    }
}
