<?php

namespace SNDLL\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\Coordonnees;

class PlatformController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNDLLPlatformBundle:Platform:index.html.twig');
    }

    public function carteAdherentsVillesAction()
    {
        return $this->render('SNDLLPlatformBundle:Platform:carteAdherentsVilles.html.twig');
    }

    public function chart1JsonDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeTousLesEtablissements = $em->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements()
        ;

        $nombreEtablissementsAvecCotisationEnCours = 0;
        $nombreEtablissementsAvecCotisationEnRetard = 0;
        $nombreEtablissementsNonAdherent = 0;

        foreach ($listeTousLesEtablissements as $etablissement)
        {
            $cotisationEnCours = null;
            if ($etablissement->getAdherent() != null AND $etablissement)
            {
                if ($etablissement->getAdherent()->getIdDerniereCotisation() != null)
                {
                    $cotisationEnCours = $em
                        ->getRepository('SNDLLPlatformBundle:Cotisation')
                        ->isCotisationEnCours($etablissement->getAdherent()->getIdDerniereCotisation());

                    if ($cotisationEnCours == True) {
                        $nombreEtablissementsAvecCotisationEnCours++;
                    } else {
                        $nombreEtablissementsAvecCotisationEnRetard++;
                    }
                } else {
                    $nombreEtablissementsAvecCotisationEnRetard++;
                }
            } else {
                $nombreEtablissementsNonAdherent++;
            }
        }

        $table = array();
        $table['cols'] = array(
            array('label' => 'Type', 'type' => 'string'),
            array('label' => 'Nombre', 'type' => 'number')
        );

        $c1 = array(
            array('v' => 'Adhérents en cours',
                'f' => null),
            array('v' => $nombreEtablissementsAvecCotisationEnCours,
                'f' => null)
        );

        $c2 = array(
            array('v' => 'Adhérents sans cotisations',
                'f' => null),
            array('v' => $nombreEtablissementsAvecCotisationEnRetard,
                'f' => null)
        );

        $c3 = array(
            array('v' => 'Non Adhérent',
                'f' => null),
            array('v' => $nombreEtablissementsNonAdherent,
                'f' => null)
        );

        $rows = array(
            array('c' => $c1),
            array('c' => $c2),
            array('c' => $c3)
        );

        $table['rows'] = $rows;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }

    public function chart2JsonDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dateActuelle = new \DateTime();
        $anneActuelle = $dateActuelle->format('Y');

        $nombreCotisationsAnneeEnCours = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCountCotisationsByAnnee($anneActuelle);

        $nombreCotisationsAnneeMoins1 = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCountCotisationsByAnnee($anneActuelle-1);

        $nombreCotisationsAnneeMoins2 = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCountCotisationsByAnnee($anneActuelle-2);

        $nombreCotisationsAnneeMoins3 = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCountCotisationsByAnnee($anneActuelle-3);

        $nombreCotisationsAnneeMoins4 = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCountCotisationsByAnnee($anneActuelle-4);

        $nombreCotisationsAnneeMoins5 = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCountCotisationsByAnnee($anneActuelle-5);

        $table = array();
        $table['cols'] = array(
            array('label' => 'Année', 'type' => 'string'),
            array('label' => 'Cotisations', 'type' => 'number'),
            array('type' => 'string', 'p' => array('role' => 'style'))
        );

        $c1 = array(
            array('v' => $anneActuelle-5,
                'f' => null),
            array('v' => $nombreCotisationsAnneeMoins5,
                'f' => null),
            array('v' => 'color: #428BCA',
                'f' => null)
        );

        $c2 = array(
            array('v' => $anneActuelle-4,
                'f' => null),
            array('v' => $nombreCotisationsAnneeMoins4,
                'f' => null),
            array('v' => 'color: #428BCA',
                'f' => null)
        );

        $c3 = array(
            array('v' => $anneActuelle-3,
                'f' => null),
            array('v' => $nombreCotisationsAnneeMoins3,
                'f' => null),
            array('v' => 'color: #428BCA',
                'f' => null)
        );

        $c4 = array(
            array('v' => $anneActuelle-2,
                'f' => null),
            array('v' => $nombreCotisationsAnneeMoins2,
                'f' => null),
            array('v' => 'color: #428BCA',
                'f' => null)
        );

        $c5 = array(
            array('v' => $anneActuelle-1,
                'f' => null),
            array('v' => $nombreCotisationsAnneeMoins1,
                'f' => null),
            array('v' => 'color: #428BCA',
                'f' => null)
        );

        $c6 = array(
            array('v' => $anneActuelle,
                'f' => null),
            array('v' => $nombreCotisationsAnneeEnCours,
                'f' => null),
            array('v' => 'color: #428BCA',
                'f' => null)
        );

        $rows = array(
            array('c' => $c1),
            array('c' => $c2),
            array('c' => $c3),
            array('c' => $c4),
            array('c' => $c5),
            array('c' => $c6)
        );

        $table['rows'] = $rows;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }

    public function chart3JsonDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeTousLesEtablissements = $em->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements()
        ;

        $nombreEtablissementsAvecCotisationEnCours = 0;
        $nombreEtablissementsAvecCotisationEnRetard = 0;

        foreach ($listeTousLesEtablissements as $etablissement)
        {
            $cotisationEnCours = null;
            if ($etablissement->getAdherent() != null AND $etablissement) {
                if ($etablissement->getAdherent()->getIdDerniereCotisation() != null) {
                    $cotisationEnCours = $em
                        ->getRepository('SNDLLPlatformBundle:Cotisation')
                        ->isCotisationEnCours($etablissement->getAdherent()->getIdDerniereCotisation());

                    if ($cotisationEnCours == True) {
                        $nombreEtablissementsAvecCotisationEnCours++;
                    } else {
                        $dateActuelle = new \DateTime();
                        $anneActuelle = $dateActuelle->format('Y');

                        $cotisationAnneePrecedente = $em
                            ->getRepository('SNDLLPlatformBundle:Cotisation')
                            ->isCotisationRecente($etablissement->getAdherent()->getIdDerniereCotisation(), $anneActuelle-1);
                        if ($cotisationAnneePrecedente == True)
                        {
                            $nombreEtablissementsAvecCotisationEnRetard++;
                        }
                    }
                }
            }
        }

        $table = array();
        $table['cols'] = array(
            array('label' => 'Type', 'type' => 'string'),
            array('label' => 'Nombre', 'type' => 'number')
        );

        $c1 = array(
            array('v' => 'Adhérent à jour',
                'f' => null),
            array('v' => $nombreEtablissementsAvecCotisationEnCours,
                'f' => null)
        );

        $c2 = array(
            array('v' => 'Adhérent en retard',
                'f' => null),
            array('v' => $nombreEtablissementsAvecCotisationEnRetard,
                'f' => null)
        );

        $rows = array(
            array('c' => $c1),
            array('c' => $c2)
        );

        $table['rows'] = $rows;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }

    public function chart4JsonDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeTousLesEtablissements = $em->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements()
        ;

        $rows = array();

        foreach ($listeTousLesEtablissements as $etablissement)
        {
            $cotisationEnCours = null;
            if ($etablissement->getAdherent() != null AND $etablissement) {
                if ($etablissement->getAdherent()->getIdDerniereCotisation() != null) {
                    $cotisationEnCours = $em
                        ->getRepository('SNDLLPlatformBundle:Cotisation')
                        ->isCotisationEnCours($etablissement->getAdherent()->getIdDerniereCotisation());

                    if ($cotisationEnCours == True) {
                        $cleRowDejaExistante = null;
                        $codePostalExiste = false;
                        foreach ($rows as $cle => $row)
                        {
                            $cpTableau = $row['c'][0]['v'];
                            $cpEtablissement = $etablissement->getCoordonnees()->getCodePostal();
                            if ($cpTableau == $cpEtablissement)
                            {
                                $codePostalExiste = true;
                                $cleRowDejaExistante = $cle;
                            }
                        }

                        if ($codePostalExiste == false)
                        {
                            $c = array(
                                array('v' => $etablissement->getCoordonnees()->getCodePostal(),
                                    'f' => null),
                                array('v' => 1,
                                    'f' => null)
                            );
                            $rows[] = array('c' => $c);
                        }
                        else
                        {
                            $row[$cleRowDejaExistante] = $rows[$cleRowDejaExistante]['c'][1]['v']++;
                        }
                    }
                }
            }
        }

        $table = array();
        $table['cols'] = array(
            array('label' => 'Region', 'type' => 'string'),
            array('label' => 'Nombre Etablissement', 'type' => 'number')
        );

        $table['rows'] = $rows;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }

    public function chart5JsonDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeTousLesEtablissements = $em->getRepository('SNDLLPlatformBundle:Etablissement')
            ->getEtablissements()
        ;

        $nbCodeAPE5630Z = 0;
        $nbCodeAPE9329Z = 0;
        $nbCodeAPEAutre = 0;
        $nbCodeAPENonRenseigne = 0;

        foreach ($listeTousLesEtablissements as $etablissement)
        {
            $cotisationEnCours = null;
            if ($etablissement->getAdherent() != null AND $etablissement)
            {
                if ($etablissement->getAdherent()->getIdDerniereCotisation() != null)
                {
                    $cotisationEnCours = $em
                        ->getRepository('SNDLLPlatformBundle:Cotisation')
                        ->isCotisationEnCours($etablissement->getAdherent()->getIdDerniereCotisation());

                    if ($cotisationEnCours == True) {
                        switch ($etablissement->getCodeAPE()->getCodeAPE()) {
                            case "5630Z":
                                $nbCodeAPE5630Z++;
                                break;
                            case "9329Z":
                                $nbCodeAPE9329Z++;
                                break;
                            case "Autre":
                                $nbCodeAPEAutre++;
                                break;
                            default:
                                $nbCodeAPENonRenseigne++;
                                break;
                        }
                    }
                }
            }
        }

        $table = array();
        $table['cols'] = array(
            array('label' => 'Type', 'type' => 'string'),
            array('label' => 'Nombre', 'type' => 'number')
        );

        $c1 = array(
            array('v' => '5630Z',
                'f' => null),
            array('v' => $nbCodeAPE5630Z,
                'f' => null)
        );

        $c2 = array(
            array('v' => '9329Z',
                'f' => null),
            array('v' => $nbCodeAPE9329Z,
                'f' => null)
        );

        $c3 = array(
            array('v' => 'Autre',
                'f' => null),
            array('v' => $nbCodeAPEAutre,
                'f' => null)
        );

        $c4 = array(
            array('v' => 'Non Renseigné',
                'f' => null),
            array('v' => $nbCodeAPENonRenseigne,
                'f' => null)
        );

        $rows = array(
            array('c' => $c1),
            array('c' => $c2),
            array('c' => $c3),
            array('c' => $c4)
        );

        $table['rows'] = $rows;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }
}
