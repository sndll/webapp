<?php
namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AdherentRepository extends EntityRepository
{
    public function codeAdherentExisteDeja($codeAdherent)
    {
        $qb = $this->createQueryBuilder('adh');

        $qb->where('adh.code_adherent = :codeadherent')
            ->setParameter('codeadherent', $codeAdherent)
        ;

        $resultat = $qb
            ->getQuery()
            ->getResult()
        ;

        if ($resultat != null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAdherents()
    {
        $qb = $this->createQueryBuilder('adh')
            ->leftJoin('adh.etablissement', 'eta')
            ->addSelect('eta')
            ->leftJoin('eta.coordonnees', 'coo')
            ->addSelect('coo')
            ->orderBy('adh.code_adherent', 'ASC')
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }
}
