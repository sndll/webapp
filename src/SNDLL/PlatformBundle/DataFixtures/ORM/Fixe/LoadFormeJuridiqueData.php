<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\FormeJuridique;

class LoadFormeJuridiqueData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $formejuridique1 = new FormeJuridique();
        $formejuridique1->setLibelle('Entreprise Individuelle');
        $manager->persist($formejuridique1);

        $formejuridique2 = new FormeJuridique();
        $formejuridique2->setLibelle('SA');
        $manager->persist($formejuridique2);

        $formejuridique3 = new FormeJuridique();
        $formejuridique3->setLibelle('SARL');
        $manager->persist($formejuridique3);

        $formejuridique4 = new FormeJuridique();
        $formejuridique4->setLibelle('SAS');
        $manager->persist($formejuridique4);

        $formejuridique5 = new FormeJuridique();
        $formejuridique5->setLibelle('EURL');
        $manager->persist($formejuridique5);

        $formejuridique6 = new FormeJuridique();
        $formejuridique6->setLibelle('Autre');
        $manager->persist($formejuridique6);

        $formejuridique7 = new FormeJuridique();
        $formejuridique7->setLibelle('Inconnue');
        $manager->persist($formejuridique7);

        $manager->flush();

        $this->addReference('FJ-Entreprise-Individuelle', $formejuridique1);
        $this->addReference('FJ-SA', $formejuridique2);
        $this->addReference('FJ-SARL', $formejuridique3);
        $this->addReference('FJ-SAS', $formejuridique4);
        $this->addReference('FJ-EURL', $formejuridique5);
        $this->addReference('FJ-Autre', $formejuridique6);
        $this->addReference('FJ-Inconnue', $formejuridique7);
    }

    public function getOrder()
    {
        return 1;
    }
}