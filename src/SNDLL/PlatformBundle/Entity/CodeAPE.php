<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="codes_ape")
 * @ORM\Entity(repositoryClass="SNDLL\PlatformBundle\Entity\CodeAPERepository")
 */
class CodeAPE
{
    /**
     * @ORM\Column(name="code_ape", type="string", length=255, unique=true)
     * @ORM\Id
     */
    protected $code_ape;

    /**
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    protected $libelle;

    public function setCodeAPE($code_ape)
    {
        $this->code_ape = $code_ape;
    }
    public function getCodeAPE()
    {
        return $this->code_ape;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }
    public function getLibelle()
    {
        return $this->libelle;
    }
}