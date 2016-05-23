<?php

namespace SNDLL\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNDLLPlatformBundle:Site:index.html.twig');
    }

    public function chart1JsonDataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeTousLesAdherents = $em->getRepository('SNDLLPlatformBundle:Adherent')
            ->getAdherents();

        $nombreIdentifiantsAvecEmail = 0;
        $nombreIdentifiantsSansEmail = 0;

        foreach ($listeTousLesAdherents as $adherent) {
            $cotisationEnCours = null;
            if ($adherent->getEtablissement()->getCoordonnees() != null) {
                if ($adherent->getEtablissement()->getCoordonnees()->getEmail() != null) {
                    $nombreIdentifiantsAvecEmail++;
                } else {
                    $nombreIdentifiantsSansEmail++;
                }
            }
        }

        $table = array();
        $table['cols'] = array(
            array('label' => 'Type', 'type' => 'string'),
            array('label' => 'Nombre', 'type' => 'number')
        );

        $c1 = array(
            array('v' => 'Avec Email',
                'f' => null),
            array('v' => $nombreIdentifiantsAvecEmail,
                'f' => null)
        );

        $c2 = array(
            array('v' => 'Sans Email',
                'f' => null),
            array('v' => $nombreIdentifiantsSansEmail,
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

    public function genTempJourWordPressAction(Request $request)
    {
        $this->container->get('wordpress_service')->genTempJourWordpress($request);

        return $this->redirect($this->generateUrl('sndll_site'));
    }

    public function genTempSemaineWordPressAction(Request $request)
    {
        $this->container->get('wordpress_service')->genTempSemaineWordpress($request);

        return $this->redirect($this->generateUrl('sndll_site'));
    }

    public function indexJsonAction()
    {
        $em = $this->getDoctrine()->getManager();

        $identifiantsTemporaires = $em
            ->getRepository('SNDLLPlatformBundle:IdentifiantsTemporaires')
            ->getIdentifiantsTemporairesValides()
        ;

        $table = null;

        foreach ($identifiantsTemporaires as $identifiantTemporaire)
        {
            $row = array("id" => $identifiantTemporaire->getId(),
                "login_WP" => $identifiantTemporaire->getLoginWP(),
                "password_WP" => $identifiantTemporaire->getPasswordWP(),
                "date_fin" => $identifiantTemporaire->getDateFin()->format('Y-m-d : H:i:s'),
            );
            $table[] = $row;
        }

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }
}
