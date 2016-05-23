<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="types_adhesions")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\TypeAdhesionRepository")
 */
class TypeAdhesion
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    protected $libelle;

    /**
     * @ORM\OneToMany(targetEntity="Cotisation", mappedBy="type_adhesion")
     */
    protected $cotisations;

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
}