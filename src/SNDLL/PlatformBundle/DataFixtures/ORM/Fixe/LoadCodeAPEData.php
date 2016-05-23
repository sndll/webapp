<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\CodeAPE;

class LoadCodeAPEData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $code_ape1 = new CodeAPE();
        $code_ape1->setCodeAPE('Inconnu');
        $code_ape1->setLibelle('Code APE non renseigné');
        $manager->persist($code_ape1);

        $code_ape2 = new CodeAPE();
        $code_ape2->setCodeAPE('9329Z');
        $code_ape2->setLibelle('Activités récréatives et de loisirs - Discothèque');
        $manager->persist($code_ape2);

        $code_ape3 = new CodeAPE();
        $code_ape3->setCodeAPE('5630Z');
        $code_ape3->setLibelle('Restauration - Bar');
        $manager->persist($code_ape3);

        $code_ape4 = new CodeAPE();
        $code_ape4->setCodeAPE('Autre');
        $code_ape4->setLibelle('Autre code APE');
        $manager->persist($code_ape4);

        $manager->flush();

        $this->addReference('CodeAPE-Inconnu', $code_ape1);
        $this->addReference('9329Z', $code_ape2);
        $this->addReference('5630Z', $code_ape3);
        $this->addReference('CodeAPE-Autre', $code_ape4);
    }

    public function getOrder()
    {
        return 1;
    }
}