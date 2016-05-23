<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Etablissement;

class LoadEtablissement2Data extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $etablissement1 = $this->getReference('Mega');
        $etablissement1->setAdherent($this->getReference('adherent1'));
        $etablissement1->setIdResponsable($this->getReference('Mozart')->getId());

        $etablissement2 = $this->getReference('Respublica');
        $etablissement2->setAdherent($this->getReference('adherent2'));
        $etablissement2->setIdResponsable($this->getReference('Beethoven')->getId());

        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}