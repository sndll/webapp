<?php

namespace SNDLL\PlatformBundle\Tests\Entity;

use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\Adherent;
use SNDLL\PlatformBundle\Entity\FormeJuridique;
use SNDLL\PlatformBundle\Entity\CodeAPE;
use SNDLL\PlatformBundle\Entity\Capacite;
use SNDLL\PlatformBundle\Entity\EtatEtablissement;
use SNDLL\PlatformBundle\Entity\Sacem;
use SNDLL\PlatformBundle\Entity\Coordonnees;
use SNDLL\PlatformBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtablissementTest extends WebTestCase
{
    private $em;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetterSetter()
    {
        $etablissement = new Etablissement();

        $etablissement->setId('1');
        $this->assertEquals('1', $etablissement->getId());

        $coordonnees = new Coordonnees();
        $etablissement->setCoordonnees($coordonnees);
        $adherent = new Adherent($this->em, $etablissement);
        $adherent->setCodeAdherent('330012005');
        $etablissement->setAdherent($adherent);
        $this->assertEquals('330012005', $etablissement->getAdherent()->getCodeAdherent());

        $contact = new Contact();
        $contact->setNom('Vinci');
        $etablissement->addContact($contact);
        $listeContacts = $etablissement->getContacts();
        $this->assertEquals('Vinci', $listeContacts[0]->getNom());
        $etablissement->removeContact($contact);
        $listeContacts = $etablissement->getContacts();
        $this->assertCount(0, $listeContacts);

        $etablissement->setEnseigne('Le MEGA');
        $this->assertEquals('Le MEGA', $etablissement->getEnseigne());
        
        $forme_jurdique = new FormeJuridique();
        $forme_jurdique->setLibelle('SARL');
        $etablissement->setFormejuridique($forme_jurdique);
        $this->assertEquals('SARL', $etablissement->getFormejuridique()->getLibelle());
        
        $etablissement->setNomJuridique('Mega Complexe SA');
        $this->assertEquals('Mega Complexe SA', $etablissement->getNomJuridique());
        
        $etablissement->setCoordonnees('1');
        $this->assertEquals('1', $etablissement->getCoordonnees());
        
        $etablissement->setSiteInternet('http://www.le_mega.fr');
        $this->assertEquals('http://www.le_mega.fr', $etablissement->getSiteInternet());
        
        $code_ape = new CodeAPE();
        $code_ape->setCodeAPE('9329Z');
        $etablissement->setCodeAPE($code_ape);
        $this->assertEquals('9329Z', $etablissement->getCodeAPE()->getCodeAPE());

        $etablissement->setCodeSIRET('776604365');
        $this->assertEquals('776604365', $etablissement->getCodeSIRET());

        $etablissement->setDateCreation('1980-01-01');
        $this->assertEquals('1980-01-01', $etablissement->getDateCreation());

        $capacite = new Capacite();
        $capacite->setLibelle('supérieur à 1500');
        $etablissement->setCapacite($capacite);
        $this->assertEquals('supérieur à 1500', $etablissement->getCapacite()->getLibelle());

        $etablissement->setNombreSalaries('10');
        $this->assertEquals('10', $etablissement->getNombreSalaries());

        $etablissement->setCommentaires('Cette établissement à déjà eu affaire au SNDLL en 2001 ...');
        $this->assertEquals('Cette établissement à déjà eu affaire au SNDLL en 2001 ...', $etablissement->getCommentaires());

        $etablissement->setIdResponsable('1');
        $this->assertEquals('1', $etablissement->getIdResponsable());

        $etat_etablissement = new EtatEtablissement();
        $etat_etablissement->setLibelle('Ouvert');
        $etablissement->setEtatEtablissement($etat_etablissement);
        $this->assertEquals('Ouvert', $etablissement->getEtatEtablissement()->getLibelle());

        $sacem = new Sacem();
        $sacem->setCodeSacem('300');
        $etablissement->setSacem($sacem);
        $this->assertEquals('300', $etablissement->getSacem()->getCodeSacem());

        $etablissement->setDateDerniereModification('2001-12-01');
        $this->assertEquals('2001-12-01', $etablissement->getDateDerniereModification());
    }
}