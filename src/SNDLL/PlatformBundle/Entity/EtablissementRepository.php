<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class EtablissementRepository extends EntityRepository
{
    public function findByEnseigne($enseigne)
    {
        $qb = $this->createQueryBuilder('eta');

        $qb->where('eta.enseigne = :enseigne')
            ->setParameter('enseigne', $enseigne)
            ->orderBy('eta.enseigne', 'ASC')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAll()
    {
        $qb = $this->createQueryBuilder('eta');

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function getEtablissements()
    {
        $qb = $this->createQueryBuilder('eta')
            ->leftJoin('eta.adherent', 'adh')
            ->addSelect('adh')
            ->leftJoin('eta.coordonnees', 'coo')
            ->addSelect('coo')
            ->leftJoin('eta.forme_juridique', 'fj')
            ->addSelect('fj')
            ->orderBy('eta.enseigne', 'ASC')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function exportAllEtablissementsQB()
    {
        $qb = $this->createQueryBuilder('eta')
            ->leftJoin('eta.adherent', 'adh')
            ->addSelect('adh')
            ->leftJoin('eta.forme_juridique', 'fj')
            ->addSelect('fj')
            ->orderBy('eta.id', 'ASC')
        ;

        return $qb->getQuery();
    }

    public function getAllEtablissements()
    {
        $qb = $this->createQueryBuilder('eta')
            ->leftJoin('eta.adherent', 'adh')
            ->addSelect('adh')
            ->leftJoin('eta.forme_juridique', 'fj')
            ->addSelect('fj')
            ->orderBy('eta.enseigne', 'ASC')
        ;

        return $qb
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function getCountAllEtablissements()
    {
        $qb = $this->createQueryBuilder('eta')
            ->select('COUNT(eta)')
        ;

        return $qb
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function isEtablissementModifieRecemment($idEtablissement, $nbAnnees, $dateImport)
    {
        $dateActuelle = new \DateTime();
        $anneeRecherchee = $dateActuelle->format('Y') - $nbAnnees;
        $dateImport = $dateImport->format('Y-m-d');
        $qb = $this->createQueryBuilder('eta');

        $qb->where('eta.id = :idEtablissement')
            ->andWhere('SUBSTRING(eta.date_derniere_modification, 1, 4) >= :anneeRecherchee')
            ->andWhere('SUBSTRING(eta.date_derniere_modification, 1, 10) <> :dateImport')
            ->setParameters(array(
                'idEtablissement' => $idEtablissement,
                'anneeRecherchee' => $anneeRecherchee,
                'dateImport' => $dateImport,
            ))
            ->setMaxResults(1)
        ;

        $resultat = $qb->getQuery()
            ->getOneOrNullResult();

        if ($resultat != null)
            return True;
        else
            return False;
    }
}
