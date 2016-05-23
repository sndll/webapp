<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SpreRepository extends EntityRepository
{
    public function getSpre()
    {
        $qb = $this->createQueryBuilder('spr');

        $qb->leftJoin('spr.coordonnees', 'coo')
            ->addSelect('coo')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()
            ->getOneOrNullResult();
    }
}
