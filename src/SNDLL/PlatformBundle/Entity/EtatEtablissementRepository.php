<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EtatEtablissementRepository extends EntityRepository
{
    public function getEtatEtablissementById($idEtatEtablissement)
    {
        $qb = $this->createQueryBuilder('ee');

        $qb->where('ee.id = :idee')
            ->setParameter('idee', $idEtatEtablissement)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
