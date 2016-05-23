<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class Export
{
    protected $dateDebut;

    protected $dateFin;

    public function __construct()
    {
        $dateDeDebut = new \DateTime();
        $dateDeDebut = $dateDeDebut->sub(new \DateInterval('P1M'));
        $dateDeFin = new \DateTime();
        $dateDeFin = $dateDeFin->add(new \DateInterval('P1D'));
        $this->dateDebut = $dateDeDebut;
        $this->dateFin = $dateDeFin;
    }

    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }
    public function getDateFin()
    {
        return $this->dateFin;
    }
}