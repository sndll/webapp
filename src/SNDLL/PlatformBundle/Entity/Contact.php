<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="contacts")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Etablissement", inversedBy="contacts")
     */
    protected $etablissement;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Civilite")
     */
    protected $civilite;

    /**
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    protected $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom;

    /**
     * @ORM\OneToOne(targetEntity="SNDLL\PlatformBundle\Entity\Coordonnees", cascade={"persist", "remove"})
     */
    private $coordonnees;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Role")
     */
    protected $role;

    /**
     * @ORM\Column(name="commentaires", type="text", nullable=true)
     */
    protected $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\EtatContact")
     */
    protected $etat_contact;

    /**
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_derniere_modification;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setEtablissement(Etablissement $etablissement)
    {
        $this->etablissement = $etablissement;
    }
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    public function setCivilite(Civilite $civilite)
    {
        $this->civilite = $civilite;
    }
    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function getNom()
    {
        return $this->nom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setCoordonnees(Coordonnees $coordonnees)
    {
        $this->coordonnees = $coordonnees;
    }
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    public function setRole(Role $role)
    {
        $this->role = $role;
    }
    public function getRole()
    {
        return $this->role;
    }

    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    public function setEtatContact(EtatContact $etat_contact)
    {
        $this->etat_contact = $etat_contact;
    }
    public function getEtatContact()
    {
        return $this->etat_contact;
    }

    public function setDateDerniereModification($date_derniere_modification)
    {
        $this->date_derniere_modification = $date_derniere_modification;
    }
    public function getDateDerniereModification()
    {
        return $this->date_derniere_modification;
    }
}