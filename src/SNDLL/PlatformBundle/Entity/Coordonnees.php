<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="coordonnees")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\CoordonneesRepository")
 */
class Coordonnees
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    protected $adresse;

    /**
     * @ORM\Column(name="code_postal", type="string", length=255, nullable=true)
     */
    protected $code_postal;

    /**
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    protected $ville;

    /**
     * @ORM\Column(name="informations_complementaires", type="text", nullable=true)
     */
    protected $informations_complementaires;

    /**
     * @ORM\Column(name="telephone_principal", type="string", length=255, nullable=true)
     */
    protected $telephone_principal;

    /**
     * @ORM\Column(name="telephone_secondaire", type="string", length=255, nullable=true)
     */
    protected $telephone_secondaire;

    /**
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    protected $fax;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @ORM\ManyToOne(targetEntity="SNDLL\PlatformBundle\Entity\Autorisation")
     */
    protected $autorisation;

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }
    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setCodePostal($code_postal)
    {
        $this->code_postal = $code_postal;
    }
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }
    public function getVille()
    {
        return $this->ville;
    }

    public function setInformationsComplementaires($informations_complementaires)
    {
        $this->informations_complementaires = $informations_complementaires;
    }
    public function getInformationsComplementaires()
    {
        return $this->informations_complementaires;
    }

    public function setTelephonePrincipal($telephone_principal)
    {
        $this->telephone_principal = $telephone_principal;
    }
    public function getTelephonePrincipal()
    {
        return $this->telephone_principal;
    }

    public function setTelephoneSecondaire($telephone_secondaire)
    {
        $this->telephone_secondaire = $telephone_secondaire;
    }
    public function getTelephoneSecondaire()
    {
        return $this->telephone_secondaire;
    }

    public function setFax($fax)
    {
        $this->fax = $fax;
    }
    public function getFax()
    {
        return $this->fax;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setAutorisation(Autorisation $autorisation)
    {
        $this->autorisation = $autorisation;
    }
    public function getAutorisation()
    {
        return $this->autorisation;
    }
}