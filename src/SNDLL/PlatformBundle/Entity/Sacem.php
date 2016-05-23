<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="sacem")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\SacemRepository")
 */
class Sacem
{
    /**
     * @ORM\Column(name="code_sacem", type="string", length=255, unique=true)
     * @ORM\Id
     */
    protected $code_sacem;

    /**
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    protected $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Coordonnees", cascade={"persist", "remove"})
     */
    protected $coordonnees;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Civilite")
     */
    protected $civilite;

    /**
     * @ORM\Column(name="nom_responsable", type="string", length=255, nullable=true)
     */
    protected $nomresponsable;

    /**
     * @ORM\Column(name="prenom_responsable", type="string", length=255, nullable=true)
     */
    protected $prenomresponsable;

    /**
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_derniere_modification;

    public function setCodeSacem($code_sacem)
    {
        $this->code_sacem = $code_sacem;
    }
    public function getCodeSacem()
    {
        return $this->code_sacem;
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

    public function setDateDerniereModification($date_derniere_modification)
    {
        $this->date_derniere_modification = $date_derniere_modification;
    }
    public function getDateDerniereModification()
    {
        return $this->date_derniere_modification;
    }
}