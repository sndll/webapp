<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;

class TypeAdhesionRepository extends EntityRepository
{
    public function getTypesAdhesions()
    {
        $qb = $this->createQueryBuilder('ta');

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
