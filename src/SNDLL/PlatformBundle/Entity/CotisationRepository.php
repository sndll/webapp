<?php

namespace SNDLL\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CotisationRepository extends EntityRepository
{
    public function getCotisationsByEtablissement(Etablissement $etablissement, $nombredecotisations)
    {
        if ($etablissement->getAdherent() != null) {
            $codeadherent = $etablissement->getAdherent()->getCodeAdherent();
            $qb = $this->createQueryBuilder('cot');

            $qb->where('cot.adherent = :codeadherent')
                ->setParameter('codeadherent', $codeadherent)
                ->orderBy('cot.date_debut', 'DESC')
                ->setMaxResults($nombredecotisations);

            return $qb
                ->getQuery()
                ->getResult();
        }
    }

    public function getCotisationsByAdherent(Adherent $adherent)
    {
        $codeadherent = $adherent->getCodeAdherent();
        $qb = $this->createQueryBuilder('cot');

        $qb->where('cot.adherent = :codeadherent')
            ->setParameter('codeadherent', $codeadherent)
            ->orderBy('cot.date_debut', 'DESC');

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function getCotisations()
    {
        $qb = $this->createQueryBuilder('cot')
            ->leftJoin('cot.adherent', 'adh')
            ->addSelect('adh')
            ->leftJoin('cot.type_adhesion', 'ta')
            ->addSelect('ta')
            ->leftJoin('cot.mode_reglement', 'mr')
            ->addSelect('mr')
            ->orderBy('cot.id', 'DESC')
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function exportAllCotisationsQB()
    {
        $qb = $this->createQueryBuilder('cot')
            ->leftJoin('cot.adherent', 'adh')
            ->addSelect('adh')
            ->leftJoin('cot.type_adhesion', 'ta')
            ->addSelect('ta')
            ->leftJoin('cot.mode_reglement', 'mr')
            ->addSelect('mr')
            ->orderBy('cot.id', 'DESC')
        ;

        return $qb
            ->getQuery();
    }

    public function getCotisationEnCours($codeAdherent)
    {
        $dateActuelle = new \DateTime();
        $qb = $this->createQueryBuilder('cot');

        $qb->leftJoin('cot.adherent', 'adh')
            ->addSelect('adh')
            ->where('adh.code_adherent = :codeadherent')
            ->andWhere('cot.date_debut < :dateactuelle')
            ->andWhere('cot.date_fin > :dateactuelle')
            ->setParameters(array(
                'codeadherent' => $codeAdherent,
                'dateactuelle' => $dateActuelle,
            ))
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getCotisationEnCoursOuFuture($codeAdherent)
    {
        $dateActuelle = new \DateTime();
        $qb = $this->createQueryBuilder('cot');

        $qb->leftJoin('cot.adherent', 'adh')
            ->addSelect('adh')
            ->where('adh.code_adherent = :codeadherent')
            ->andWhere('cot.date_fin > :dateactuelle')
            ->setParameters(array(
                'codeadherent' => $codeAdherent,
                'dateactuelle' => $dateActuelle,
            ))
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getCotisationAnneeProchaine($codeAdherent)
    {
        $dateActuelle = new \DateTime();
        $anneeProchaine = $dateActuelle->format("Y");
        $anneeProchaine++;
        $qb = $this->createQueryBuilder('cot');

        $qb->leftJoin('cot.adherent', 'adh')
            ->addSelect('adh')
            ->where('adh.code_adherent = :codeadherent')
            ->andWhere('SUBSTRING(cot.date_fin, 1, 4) >= :anneeProchaine')
            ->setParameters(array(
                'codeadherent' => $codeAdherent,
                'anneeProchaine' => $anneeProchaine,
            ))
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function isCotisationEnCours($idCotisation)
    {
        $dateActuelle = new \DateTime();
        $qb = $this->createQueryBuilder('cot');

        $qb->where('cot.id = :idcotisation')
            ->andWhere('cot.date_debut < :dateactuelle')
            ->andWhere('cot.date_fin > :dateactuelle')
            ->setParameters(array(
                'idcotisation' => $idCotisation,
                'dateactuelle' => $dateActuelle,
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

    public function isCotisationRecente($idCotisation, $annee)
    {
        $qb = $this->createQueryBuilder('cot');

        $qb->where('cot.id = :idcotisation')
            ->andWhere('SUBSTRING(cot.date_reglement, 1, 4) >= :anneeRecherchee')
            ->orWhere('cot.id = :idcotisation')
            ->andWhere('SUBSTRING(cot.date_fin, 1, 4) >= :anneeRecherchee')
            ->setParameters(array(
                'idcotisation' => $idCotisation,
                'anneeRecherchee' => $annee,
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

    public function getCountCotisationsByAnnee($annee)
    {
        $qb = $this->createQueryBuilder('cot')
            ->select('COUNT(cot)')
            ->where('SUBSTRING(cot.date_debut, 1, 4) <= :annee')
            ->andWhere('SUBSTRING(cot.date_fin, 1, 4) >= :annee')
            ->setParameters(array(
                'annee' => $annee
            ))
        ;

        return $qb
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function getDerniereCotisation($codeAdherent)
    {
        $qb = $this->createQueryBuilder('cot')
            ->Join('cot.adherent', 'adh')
            ->addSelect('adh')
            ->where('adh.code_adherent = :code_adherent')
            ->setParameters(array(
                'code_adherent' => $codeAdherent
            ))
            ->orderBy('cot.date_fin', 'DESC')
            ->setMaxResults(1);

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getCotisationsByDateReglement($dateDebut, $dateFin)
    {
        $dateDebut = $dateDebut->format('Y-m-d H-i-s');
        $dateFin = $dateFin->format('Y-m-d H-i-s');
        $qb = $this->createQueryBuilder('cot');

        $qb->leftJoin('cot.adherent', 'adh')
            ->addSelect('adh')
            ->leftJoin('adh.etablissement', 'eta')
            ->addSelect('eta')
            ->Join('eta.sacem', 'sac')
            ->addSelect('sac')
            ->where('cot.date_reglement >= :dateDebut')
            ->andWhere('cot.date_reglement <= :dateFin')
            ->setParameters(array(
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin,
            ))
            ->orderBy('sac.code_sacem', 'ASC')
        ;

        return $qb
            ->getQuery()
            ->getResult();
    }
}
