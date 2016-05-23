<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\ModeReglement;

class LoadModeReglementData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $mode_reglement1 = new ModeReglement();
        $mode_reglement1->setLibelle('Chèque');
        $manager->persist($mode_reglement1);

        $mode_reglement2 = new ModeReglement();
        $mode_reglement2->setLibelle('Paypal');
        $manager->persist($mode_reglement2);

        $mode_reglement3 = new ModeReglement();
        $mode_reglement3->setLibelle('Virement');
        $manager->persist($mode_reglement3);

        $mode_reglement4 = new ModeReglement();
        $mode_reglement4->setLibelle('Espèces');
        $manager->persist($mode_reglement4);

        $mode_reglement5 = new ModeReglement();
        $mode_reglement5->setLibelle('Autre');
        $manager->persist($mode_reglement5);

        $mode_reglement6 = new ModeReglement();
        $mode_reglement6->setLibelle('Aucun');
        $manager->persist($mode_reglement6);

        $manager->flush();

        $this->addReference('MR-Cheque', $mode_reglement1);
        $this->addReference('MR-Paypal', $mode_reglement2);
        $this->addReference('MR-Virement', $mode_reglement3);
        $this->addReference('MR-Especes', $mode_reglement4);
        $this->addReference('MR-Autre', $mode_reglement5);
        $this->addReference('MR-Aucun', $mode_reglement6);
    }

    public function getOrder()
    {
        return 1;
    }
}