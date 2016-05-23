<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Identifiants;

class LoadIdentifiantsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $identifiants1 = new Identifiants();
        $identifiants1->setLoginWP('LeCLUB');
        $identifiants1->setPasswordWP('123456789');
        $identifiants1->setDateDerniereModification(new \DateTime());

        $manager->persist($identifiants1);

        $manager->flush();

        $identifiants2 = new Identifiants();
        $identifiants2->setLoginWP('Lily');
        $identifiants2->setPasswordWP('lily33');
        $identifiants2->setDateDerniereModification(new \DateTime());

        $manager->persist($identifiants2);

        $manager->flush();
        
        $this->addReference('identifiants1', $identifiants1);
        $this->addReference('identifiants2', $identifiants2);
    }

    public function getOrder()
    {
        return 1;
    }
}