<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function getResponsable($etablissementId)
    {
        $qb = $this->createQueryBuilder('con')
            ->leftJoin('con.etablissement', 'eta')
            ->addSelect('eta')
            ->leftJoin('con.role', 'rol')
            ->addSelect('rol')
            ->where('eta.id = :eta_id')
            ->andWhere('rol.id = 2')
            ->setParameters(array(
                'eta_id' => $etablissementId,
            ))
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function getAutreResponsable($etablissementId, $idResponsable)
    {
        $qb = $this->createQueryBuilder('con')
            ->leftJoin('con.etablissement', 'eta')
            ->addSelect('eta')
            ->leftJoin('con.role', 'rol')
            ->addSelect('rol')
            ->where('eta.id = :eta_id')
            ->andWhere('rol.id = 2')
            ->andWhere('con.id != :responsable_id')
            ->setParameters(array(
                'eta_id' => $etablissementId,
                'responsable_id' => $idResponsable,
            ))
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function getContacts()
    {
        $qb = $this->createQueryBuilder('con')
            ->Join('con.etablissement', 'eta')
            ->addSelect('eta')
            ->Join('con.civilite', 'civ')
            ->addSelect('civ')
            ->Join('con.coordonnees', 'coo')
            ->addSelect('coo')
            ->Join('con.role', 'role')
            ->addSelect('role')
            ->Join('con.etat_contact', 'ec')
            ->addSelect('ec')
            ->orderBy('con.id', 'ASC')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
