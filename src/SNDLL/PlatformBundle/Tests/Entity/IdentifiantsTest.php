<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Identifiants;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IdentifiantsTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetterSetter()
    {
        $identifiants = new Identifiants();

        $identifiants->setId('1');
        $this->assertEquals('1', $identifiants->getId());

        $identifiants->setLoginWP('LeClub');
        $this->assertEquals('LeClub', $identifiants->getLoginWP());

        $identifiants->setPasswordWP('123456789');
        $this->assertEquals('123456789', $identifiants->getPasswordWP());

        $identifiants->setDateDerniereModification('2014-01-31');
        $this->assertEquals('2014-01-31', $identifiants->getDateDerniereModification());
    }
}