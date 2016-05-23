<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Coordonnees;

class LoadCoordonneesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $coordonnees1 = new Coordonnees();
        $coordonnees1->setAdresse('16 rue des platanes');
        $coordonnees1->setCodePostal('33470');
        $coordonnees1->setVille('Gujan Mestras');
        $coordonnees1->setInformationsComplementaires("Anciennement rue des grépins");
        $coordonnees1->setTelephonePrincipal('0556603321');
        $coordonnees1->setTelephoneSecondaire('0653603321');
        $coordonnees1->setFax('0556603322');
        $coordonnees1->setEmail('contact@mega.com');
        $coordonnees1->setAutorisation($this->getReference('Autorisation-Urgences-Newsletters'));
        $manager->persist($coordonnees1);

        $coordonnees2 = new Coordonnees();
        $coordonnees2->setAdresse('15 rue des cerisiers');
        $coordonnees2->setCodePostal('33740');
        $coordonnees2->setVille('Arès');
        $coordonnees2->setTelephonePrincipal('0556603521');
        $coordonnees2->setTelephoneSecondaire('0653603521');
        $coordonnees2->setFax('0556603522');
        $coordonnees2->setEmail('email@respublica.com');
        $coordonnees2->setAutorisation($this->getReference('Autorisation-Urgences-Newsletters'));
        $manager->persist($coordonnees2);

        $coordonnees3 = new Coordonnees();
        $coordonnees3->setAdresse('154 cours de la Blaye');
        $coordonnees3->setCodePostal('33000');
        $coordonnees3->setVille('Bordeaux');
        $coordonnees3->setTelephonePrincipal('0556283521');
        $coordonnees3->setTelephoneSecondaire('0656283521');
        $coordonnees3->setFax('0556283522');
        $coordonnees3->setEmail('mozart@gmail.com');
        $coordonnees3->setAutorisation($this->getReference('Autorisation-Urgences'));
        $manager->persist($coordonnees3);

        $coordonnees4 = new Coordonnees();
        $coordonnees4->setAdresse('154 cours de la Marne');
        $coordonnees4->setCodePostal('33000');
        $coordonnees4->setVille('Bordeaux');
        $coordonnees4->setTelephonePrincipal('0554583521');
        $coordonnees4->setTelephoneSecondaire('0655483521');
        $coordonnees4->setFax('0554283522');
        $coordonnees4->setEmail('beethoven@gmail.com');
        $coordonnees4->setAutorisation($this->getReference('Autorisation-Urgences'));
        $manager->persist($coordonnees4);

        $coordonnees5 = new Coordonnees();
        $coordonnees5->setAdresse('26 Quai de Bacalan');
        $coordonnees5->setCodePostal('33053');
        $coordonnees5->setVille('Bordeaux');
        $coordonnees5->setTelephonePrincipal('0567348010');
        $coordonnees5->setFax('0567348011');
        $coordonnees5->setEmail('dl.bordeaux@sacem.fr');
        $manager->persist($coordonnees5);

        $coordonnees6 = new Coordonnees();
        $coordonnees6->setCodePostal('33053');
        $coordonnees6->setVille('Bordeaux');
        $coordonnees6->setTelephonePrincipal('0567348020');
        $coordonnees6->setFax('0567348021');
        $coordonnees6->setEmail('delegation.bordeaux@sacem.fr');
        $manager->persist($coordonnees6);

        $manager->flush();

        $this->addReference('Coordonnees-Mega-Etablissement', $coordonnees1);
        $this->addReference('Coordonnees-Respublica-Etablissement', $coordonnees2);
        $this->addReference('Coordonnees-Mega-Directeur', $coordonnees3);
        $this->addReference('Coordonnees-Respublica-Directeur', $coordonnees4);
        $this->addReference('Coordonnees-Sacem-Direction-Regional-Sud-Ouest', $coordonnees5);
        $this->addReference('Coordonnees-Sacem-Delegation-Sud-Ouest', $coordonnees6);
    }

    public function getOrder()
    {
        return 2;
    }
}