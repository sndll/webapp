<?php

namespace SNDLL\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SNDLL\PlatformBundle\Entity\Contact;

class LoadContactData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $contact1 = new Contact();
        $contact1->setEtablissement($this->getReference('Mega'));
        $contact1->setCivilite($this->getReference('Civilite-Monsieur'));
        $contact1->setNom('Mozart');
        $contact1->setPrenom('Wolfgang');
        $contact1->setCoordonnees($this->getReference('Coordonnees-Mega-Directeur'));
        $contact1->setRole($this->getReference('Role-Responsable'));
        $contact1->setCommentaires("Un grand monsieur");
        $contact1->setEtatContact($this->getReference('EtatContact-Actif'));
        $contact1->setDateDerniereModification(new \DateTime());

        $manager->persist($contact1);

        $contact2 = new Contact();
        $contact2->setEtablissement($this->getReference('Respublica'));
        $contact2->setCivilite($this->getReference('Civilite-Monsieur'));
        $contact2->setNom('Beethoven');
        $contact2->setPrenom('Ludwig');
        $contact2->setCoordonnees($this->getReference('Coordonnees-Respublica-Directeur'));
        $contact2->setRole($this->getReference('Role-Responsable'));
        $contact2->setCommentaires("Un autre grand monsieur");
        $contact2->setEtatContact($this->getReference('EtatContact-Actif'));
        $contact2->setDateDerniereModification(new \DateTime());

        $manager->persist($contact2);

        $manager->flush();

        $this->addReference('Mozart', $contact1);
        $this->addReference('Beethoven', $contact2);
    }

    public function getOrder()
    {
        return 5;
    }
}