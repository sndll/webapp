<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

class IdentifiantsTemporairesRepository extends EntityRepository
{
    public function getIdentifiantsTemporairesValides()
    {
        $dateActuelle = new \DateTime();

        $qb = $this->createQueryBuilder('idt')
        ->where('idt.date_debut <= :dateactuelle')
        ->andWhere('idt.date_fin >= :dateactuelle')
        ->setParameters(array(
            'dateactuelle' => $dateActuelle,
        ))
            ->orderBy('idt.id', 'DESC')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
