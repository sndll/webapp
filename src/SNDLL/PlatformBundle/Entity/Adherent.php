<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Table(name="adherents")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\AdherentRepository")
 */
class Adherent
{
    /**
     * @ORM\Column(name="code_adherent", type="string", length=255, unique=true)
     * @ORM\Id
     */
    protected $code_adherent;

    /**
     * @ORM\OneToMany(targetEntity="Cotisation", mappedBy="adherent", cascade={"remove", "persist"})
     */
    protected $cotisations;

    /**
     * @ORM\OneToOne(targetEntity="Etablissement", mappedBy="adherent")
     */
    protected $etablissement;

    /**
     * @ORM\Column(name="date_premiere_cotisation", type="date", nullable=true)
     */
    protected $date_premiere_cotisation;

    /**
     * @ORM\Column(name="id_derniere_cotisation", type="integer", nullable=true)
     */
    protected $id_derniere_cotisation;

    protected $etat_cotisation;

    /**
     * @ORM\OneToOne(targetEntity="SNDLL\PlatformBundle\Entity\Identifiants", cascade={"persist", "remove"})
     */
    protected $identifiants;

    /**
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_derniere_modification;

    protected $em;

    public function __construct(EntityManager $entityManager, Etablissement $etablissement )
    {
        $this->em = $entityManager;
        $this->cotisations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etablissement = $etablissement;
        $this->generationCodeAdherent();
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setCodeAdherent($code_adherent)
    {
        $this->code_adherent = $code_adherent;
    }
    public function getCodeAdherent()
    {
        return $this->code_adherent;
    }

    public function addCotisation(Cotisation $cotisation)
    {
        $this->cotisations[] = $cotisation;
    }
    public function removeCotisation(Cotisation $cotisation)
    {
        $this->cotisations->removeElement($cotisation);
    }
    public function getCotisations()
    {
        return $this->cotisations;
    }

    public function setEtablissement(Etablissement $etablissement)
    {
        $this->etablissement = $etablissement;
    }
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    public function setDatePremiereCotisation($date_premiere_cotisation)
    {
        $this->date_premiere_cotisation = $date_premiere_cotisation;
    }
    public function getDatePremiereCotisation()
    {
        return $this->date_premiere_cotisation;
    }

    public function setIdDerniereCotisation($idDerniereCotisation)
    {
        $this->id_derniere_cotisation = $idDerniereCotisation;
    }
    public function getIdDerniereCotisation()
    {
        return $this->id_derniere_cotisation;
    }

    public function setDateDerniereModification($date_derniere_modification)
    {
        $this->date_derniere_modification = $date_derniere_modification;
    }
    public function getDateDerniereModification()
    {
        return $this->date_derniere_modification;
    }

    public function generationCodeAdherent()
    {
        if ($this->etablissement->getAdherent() != null)
        {
            throw new \Exception('L\'établissement possède déjà un code adhérent');
        }
        $codePostal = $this->etablissement->getCoordonnees()->getCodePostal();
        $numeroDepartement = substr( $codePostal , 0 , 2 );
        $dateCourante = new \DateTime();
        $anneeCourante = $dateCourante->format('Y');

        for ($cle = 1; $cle <= 999; $cle++)
        {
            while(strlen($cle) < 3)
                $cle = "0" . $cle;
            $codeAdherent = $numeroDepartement.$cle.$anneeCourante;
            $resultat = $this->em->getRepository('SNDLLPlatformBundle:Adherent')->codeAdherentExisteDeja($codeAdherent);
            if ($resultat == null)
            {
                $this->code_adherent = $codeAdherent;
                return 0;
            }
        }
        throw new \Exception('Impossible de générer le code adhérent de l\'adhérent');
    }

    public function setEtatCotisation($etatCotisation)
    {
        $this->etat_cotisation = $etatCotisation;
    }
    public function getEtatCotisation()
    {
        return $this->etat_cotisation;
    }

    public function setIdentifiants($identifiants)
    {
        $this->identifiants = $identifiants;
    }
    public function getIdentifiants()
    {
        return $this->identifiants;
    }
}