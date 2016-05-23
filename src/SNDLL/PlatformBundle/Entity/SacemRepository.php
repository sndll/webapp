<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class SacemRepository extends EntityRepository
{
    public function getCentresSACEM()
    {
        $qb = $this->createQueryBuilder('sac')
            ->orderBy('sac.code_sacem', 'ASC')
        ;

        return $qb->getQuery()
            ->getResult()
        ;
    }
}
