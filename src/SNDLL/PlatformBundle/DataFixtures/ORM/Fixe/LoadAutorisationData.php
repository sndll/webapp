<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Autorisation;

class LoadAutorisationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $autorisation1 = new Autorisation();
        $autorisation1->setLibelle('Urgences Seulement');
        $manager->persist($autorisation1);

        $autorisation2 = new Autorisation();
        $autorisation2->setLibelle('Urgences + Newsletters');
        $manager->persist($autorisation2);

        $manager->flush();

        $this->addReference('Autorisation-Urgences', $autorisation1);
        $this->addReference('Autorisation-Urgences-Newsletters', $autorisation2);
    }

    public function getOrder()
    {
        return 1;
    }
}