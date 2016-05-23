<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="identifiants")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\IdentifiantsRepository")
 */
class Identifiants
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
     * @ORM\Column(name="date_derniere_modification", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date_derniere_modification;

    public function __construct()
    {
    }

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

    public function setDateDerniereModification($date_derniere_modification)
    {
        $this->date_derniere_modification = $date_derniere_modification;
    }
    public function getDateDerniereModification()
    {
        return $this->date_derniere_modification;
    }
}