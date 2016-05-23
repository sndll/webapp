<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="cotisations")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\CotisationRepository")
 */
class Cotisation
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Adherent", inversedBy="cotisations")
     * @ORM\JoinColumn(name="code_adherent", referencedColumnName="code_adherent")
     */
    protected $adherent;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\TypeAdhesion", inversedBy="cotisations")
     */
    protected $type_adhesion;

    /**
     * @ORM\Column(name="prix_cotisation_ttc", type="float")
     */
    protected $prix_cotisation_ttc;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\ModeReglement")
     */
    protected $mode_reglement;

    /**
     * @ORM\Column(name="date_debut", type="date")
     * @Assert\DateTime()
     */
    protected $date_debut;

    /**
     * @ORM\Column(name="date_fin", type="date")
     * @Assert\DateTime()
     */
    protected $date_fin;

    /**
     * @ORM\Column(name="date_reglement", type="datetime")
     * @Assert\DateTime()
     */
    protected $date_reglement;

    public function __construct()
    {
        $dateActuelle = new \DateTime();
        $anneActuelle = $dateActuelle->format('Y');
        $this->date_debut = new \DateTime($anneActuelle.'-01-01');
        $this->date_fin = new \DateTime($anneActuelle.'-12-31');
        $this->date_reglement = new \DateTime();
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

    public function setTypeAdhesion(TypeAdhesion $type_adhesion)
    {
        $this->type_adhesion = $type_adhesion;
    }
    public function getTypeAdhesion()
    {
        return $this->type_adhesion;
    }

    public function setPrixCotisationTTC($prix_cotisation_ttc)
    {
        $this->prix_cotisation_ttc = $prix_cotisation_ttc;
    }
    public function getPrixCotisationTTC()
    {
        return $this->prix_cotisation_ttc;
    }

    public function setModeReglement(ModeReglement $mode_reglement)
    {
        $this->mode_reglement = $mode_reglement;
    }
    public function getModeReglement()
    {
        return $this->mode_reglement;
    }

    public function setDateDebut($date_debut)
    {
        $this->date_debut = $date_debut;
    }
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
    }
    public function getDateFin()
    {
        return $this->date_fin;
    }

    public function setDateReglement($date_reglement)
    {
        $this->date_reglement = $date_reglement;
    }
    public function getDateReglement()
    {
        return $this->date_reglement;
    }
}