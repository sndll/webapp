<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="etablissements")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\EtablissementRepository")
 */
class Etablissement
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="SNDLL\PlatformBundle\Entity\Adherent", inversedBy="etablissement", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="code_adherent", referencedColumnName="code_adherent")
     */
    protected $adherent;

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="etablissement", cascade={"persist", "remove"})
     */
    protected $contacts;

    /**
     * @ORM\Column(name="enseigne", type="string", length=255, nullable=true)
     */
    protected $enseigne;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\FormeJuridique")
     */
    protected $forme_juridique;

    /**
     * @ORM\Column(name="nom_juridique", type="string", length=255, nullable=true)
     */
    protected $nom_juridique;

    /**
     * @ORM\OneToOne(targetEntity="SNDLL\PlatformBundle\Entity\Coordonnees", cascade={"persist", "remove"})
     */
    protected $coordonnees;

    /**
     * @ORM\Column(name="site_internet", type="string", length=255, nullable=true)
     */
    protected $site_internet;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\CodeAPE")
     * @ORM\JoinColumn(name="code_ape", referencedColumnName="code_ape")
     */
    protected $code_ape;

    /**
     * @ORM\Column(name="code_siret", type="string", length=255, nullable=true)
     */
    protected $code_siret;

    /**
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_creation;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Capacite")
     */
    protected $capacite;

    /**
     * @ORM\Column(name="nombre_salaries", type="integer", nullable=true)
     */
    protected $nombre_salaries;

    /**
     * @ORM\Column(name="commentaires", type="text", nullable=true)    
     */
    protected $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\EtatEtablissement")
     */
    protected $etat_etablissement;

    /**
     * @ORM\Column(name="id_responsable", type="integer", nullable=true)
     */
    protected $id_responsable;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Sacem")
     * @ORM\JoinColumn(name="code_sacem", referencedColumnName="code_sacem")
     */
    protected $sacem;

    /**
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_derniere_modification;

    protected $responsable;

    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setAdherent(Adherent $adherent)
    {
        $this->adherent = $adherent;
    }
    public function getAdherent()
    {
        return $this->adherent;
    }

    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }
    public function removeContact(Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }
    public function getContacts()
    {
        return $this->contacts;
    }

    public function setEnseigne($enseigne)
    {
        $this->enseigne = $enseigne;
    }
    public function getEnseigne()
    {
        return $this->enseigne;
    }

    public function setFormejuridique(FormeJuridique $forme_juridique)
    {
        $this->forme_juridique = $forme_juridique;
    }
    public function getFormejuridique()
    {
        return $this->forme_juridique;
    }

    public function setNomJuridique($nom_juridique)
    {
        $this->nom_juridique = $nom_juridique;
    }
    public function getNomJuridique()
    {
        return $this->nom_juridique;
    }

    public function setCoordonnees($coordonnes)
    {
        $this->coordonnees = $coordonnes;
    }
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    public function setSiteInternet($site_internet)
    {
        $this->site_internet = $site_internet;
    }
    public function getSiteInternet()
    {
        return $this->site_internet;
    }

    public function setCodeAPE(CodeAPE $code_ape)
    {
        $this->code_ape = $code_ape;
    }
    public function getCodeAPE()
    {
        return $this->code_ape;
    }

    public function setCodeSIRET($code_siret)
    {
        $this->code_siret = $code_siret;
    }
    public function getCodeSIRET()
    {
        return $this->code_siret;
    }

    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function setCapacite(Capacite $capacite)
    {
        $this->capacite = $capacite;
    }
    public function getCapacite()
    {
        return $this->capacite;
    }

    public function setNombreSalaries($nombre_salaries)
    {
        $this->nombre_salaries = $nombre_salaries;
    }
    public function getNombreSalaries()
    {
        return $this->nombre_salaries;
    }

    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    public function setIdResponsable($idResponsable)
    {
        $this->id_responsable = $idResponsable;
    }
    public function getIdResponsable()
    {
        return $this->id_responsable;
    }

    public function setEtatEtablissement(EtatEtablissement $etat_etablissement)
    {
        $this->etat_etablissement = $etat_etablissement;
    }
    public function getEtatEtablissement()
    {
        return $this->etat_etablissement;
    }

    public function setSacem(Sacem $sacem)
    {
        $this->sacem = $sacem;
    }
    public function getSacem()
    {
        return $this->sacem;
    }

    public function setDateDerniereModification($date_derniere_modification)
    {
        $this->date_derniere_modification = $date_derniere_modification;
    }
    public function getDateDerniereModification()
    {
        return $this->date_derniere_modification;
    }

    public function setResponsable(Contact $responsable = null)
    {
        $this->responsable = $responsable;
    }
    public function getResponsable()
    {
        return $this->responsable;
    }
}