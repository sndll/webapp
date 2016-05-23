<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Cotisation;

class LoadCotisationData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cotisation1 = new Cotisation();
        $cotisation1->setAdherent($this->getReference('adherent1'));
        $cotisation1->setTypeAdhesion($this->getReference('TypeAdhesion-Base'));
        $cotisation1->setPrixCotisationTTC(460);
        $cotisation1->setModeReglement($this->getReference('MR-Cheque'));
        $cotisation1->setDateDebut(new \DateTime('2015-01-01'));
        $cotisation1->setDateFin(new \DateTime('2015-12-31'));
        $cotisation1->setDateReglement(new \DateTime('2015-01-05'));

        $manager->persist($cotisation1);

        $cotisation2 = new Cotisation();
        $cotisation2->setAdherent($this->getReference('adherent2'));
        $cotisation2->setTypeAdhesion($this->getReference('TypeAdhesion-Base'));
        $cotisation2->setPrixCotisationTTC(175);
        $cotisation2->setModeReglement($this->getReference('MR-Cheque'));
        $cotisation2->setDateDebut(new \DateTime('2010-06-01'));
        $cotisation2->setDateFin(new \DateTime('2010-12-31'));
        $cotisation2->setDateReglement(new \DateTime('2010-06-01'));

        $manager->persist($cotisation2);

        $cotisation3 = new Cotisation();
        $cotisation3->setAdherent($this->getReference('adherent2'));
        $cotisation3->setTypeAdhesion($this->getReference('TypeAdhesion-Base'));
        $cotisation3->setPrixCotisationTTC(350);
        $cotisation3->setModeReglement($this->getReference('MR-Cheque'));
        $cotisation3->setDateDebut(new \DateTime('2011-01-01'));
        $cotisation3->setDateFin(new \DateTime('2011-12-31'));
        $cotisation3->setDateReglement(new \DateTime('2010-12-01'));

        $manager->persist($cotisation3);
        
        $cotisation4 = new Cotisation();
        $cotisation4->setAdherent($this->getReference('adherent2'));
        $cotisation4->setTypeAdhesion($this->getReference('TypeAdhesion-Premium'));
        $cotisation4->setPrixCotisationTTC(450);
        $cotisation4->setModeReglement($this->getReference('MR-Cheque'));
        $cotisation4->setDateDebut(new \DateTime('2012-01-01'));
        $cotisation4->setDateFin(new \DateTime('2012-12-31'));
        $cotisation4->setDateReglement(new \DateTime('2012-01-01'));

        $manager->persist($cotisation4);

        $cotisation5 = new Cotisation();
        $cotisation5->setAdherent($this->getReference('adherent2'));
        $cotisation5->setTypeAdhesion($this->getReference('TypeAdhesion-Premium'));
        $cotisation5->setPrixCotisationTTC(450);
        $cotisation5->setModeReglement($this->getReference('MR-Cheque'));
        $cotisation5->setDateDebut(new \DateTime('2013-01-01'));
        $cotisation5->setDateFin(new \DateTime('2013-12-31'));
        $cotisation5->setDateReglement(new \DateTime('2013-01-01'));

        $manager->persist($cotisation5);

        $cotisation6 = new Cotisation();
        $cotisation6->setAdherent($this->getReference('adherent2'));
        $cotisation6->setTypeAdhesion($this->getReference('TypeAdhesion-Premium'));
        $cotisation6->setPrixCotisationTTC(460);
        $cotisation6->setModeReglement($this->getReference('MR-Cheque'));
        $cotisation6->setDateDebut(new \DateTime('2014-01-01'));
        $cotisation6->setDateFin(new \DateTime('2014-12-31'));
        $cotisation6->setDateReglement(new \DateTime('2014-01-01'));

        $manager->persist($cotisation6);

        $manager->flush();
        
        $this->addReference('cotisation1', $cotisation1);
        $this->addReference('cotisation2', $cotisation2);
        $this->addReference('cotisation3', $cotisation3);
        $this->addReference('cotisation4', $cotisation4);
        $this->addReference('cotisation5', $cotisation5);
        $this->addReference('cotisation6', $cotisation6);
    }

    public function getOrder()
    {
        return 6;
    }
}