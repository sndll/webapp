<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="spre")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\SpreRepository")
 */
class Spre
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    protected $libelle;

    /**
     * @ORM\OneToOne(targetEntity="SNDLL\PlatformBundle\Entity\Coordonnees", cascade={"persist", "remove"})
     */
    protected $coordonnees;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Civilite")
     */
    protected $civilite;

    /**
     * @ORM\Column(name="nom_responsable", type="string", length=255)
     */
    protected $nomresponsable;

    /**
     * @ORM\Column(name="prenom_responsable", type="string", length=255)
     */
    protected $prenomresponsable;

    /**
     * @ORM\Column(name="date_derniere_modification", type="datetime")
     * @Assert\DateTime()
     */
    protected $datedernieremodification;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }
    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setCoordonnees(Coordonnees $coordonnees)
    {
        $this->coordonnees = $coordonnees;
    }
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    public function setCivilite(Civilite $civilite)
    {
        $this->civilite = $civilite;
    }
    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setNomResponsable($nomResponsable)
    {
        $this->nomresponsable = $nomResponsable;
    }
    public function getNomResponsable()
    {
        return $this->nomresponsable;
    }

    public function setPrenomResponsable($prenomResponsable)
    {
        $this->prenomresponsable = $prenomResponsable;
    }
    public function getPrenomResponsable()
    {
        return $this->prenomresponsable;
    }

    public function setDateDerniereModification($dateDerniereModification)
    {
        $this->datedernieremodification = $dateDerniereModification;
    }
    public function getDateDerniereModification()
    {
        return $this->datedernieremodification;
    }
}