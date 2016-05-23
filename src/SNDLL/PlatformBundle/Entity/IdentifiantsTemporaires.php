<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="identifiants_temporaires")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\IdentifiantsTemporairesRepository")
 */
class IdentifiantsTemporaires
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="login_wp", type="string")
     */
    protected $login_WP;

    /**
     * @ORM\Column(name="password_wp", type="string")
     */
    protected $password_WP;

    /**
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_creation;

    /**
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_debut;

    /**
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_fin;


    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setLoginWP($login)
    {
        $this->login_WP = $login;
    }
    public function getLoginWP()
    {
        return $this->login_WP;
    }

    public function setPasswordWP($password)
    {
        $this->password_WP = $password;
    }
    public function getPasswordWP()
    {
        return $this->password_WP;
    }

    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }
    public function getDateCreation()
    {
        return $this->date_creation;
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
}