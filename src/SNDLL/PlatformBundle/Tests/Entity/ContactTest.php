<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Contact;
use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\Role;
use SNDLL\PlatformBundle\Entity\Civilite;
use SNDLL\PlatformBundle\Entity\EtatContact;
use SNDLL\PlatformBundle\Entity\Coordonnees;

class ContactTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $contact = new Contact();

        $contact->setId('1');
        $this->assertEquals('1', $contact->getId());

        $etablissement = new Etablissement();
        $etablissement->setEnseigne('Le Luxor');
        $contact->setEtablissement($etablissement);
        $this->assertEquals('Le Luxor', $contact->getEtablissement()->getEnseigne());

        $civilite = new Civilite();
        $civilite->setLibelle('Monsieur');
        $contact->setCivilite($civilite);
        $this->assertEquals('Monsieur', $contact->getCivilite()->getLibelle());

        $contact->setNom('Malvaes');
        $this->assertEquals('Malvaes', $contact->getNom());

        $contact->setPrenom('Patrick');
        $this->assertEquals('Patrick', $contact->getPrenom());

        $coordonnees = new Coordonnees();
        $coordonnees->setAdresse('16 rue du test');
        $contact->setCoordonnees($coordonnees);
        $this->assertEquals('16 rue du test', $contact->getCoordonnees()->getAdresse());

        $role = new Role();
        $role->setLibelle('Directeur');
        $contact->setRole($role);
        $this->assertEquals('Directeur', $contact->getRole()->getLibelle());

        $contact->setCommentaires('Egalement directeur de la Gueriniere');
        $this->assertEquals('Egalement directeur de la Gueriniere', $contact->getCommentaires());

        $etat_contact = new EtatContact();
        $etat_contact->setLibelle('Actif');
        $contact->setEtatContact($etat_contact);
        $this->assertEquals('Actif', $contact->getEtatContact()->getLibelle());

        $contact->setDateDerniereModification('2015-07-01');
        $this->assertEquals('2015-07-01', $contact->getDateDerniereModification());
    }
}