<?php

namespace SNDLL\PlatformBundle\Controller;

use SNDLL\PlatformBundle\Entity\Adherent;
use SNDLL\PlatformBundle\Entity\Etablissement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SNDLL\PlatformBundle\Form\EtablissementAddType;
use SNDLL\PlatformBundle\Form\EtablissementEditType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EtablissementController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNDLLPlatformBundle:Etablissement:index.html.twig');
    }

    public function indexJsonAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conn = $this->get('database_connection');
        $etablissements = $conn->fetchAll('SELECT etablissements.id, enseigne, etablissements.code_adherent, code_postal, id_derniere_cotisation, date_debut, date_fin, nom FROM etablissements LEFT JOIN coordonnees ON coordonnees_id = coordonnees.id LEFT JOIN adherents ON etablissements.code_adherent = adherents.code_adherent LEFT JOIN cotisations ON adherents.id_derniere_cotisation = cotisations.id LEFT JOIN contacts ON etablissements.id_responsable = contacts.id ORDER BY etablissements.id');

        $table = $etablissements;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function viewAction(Etablissement $etablissement)
    {
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $nombredecotisations = 5;
        $cotisations = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisationsByEtablissement($etablissement, $nombredecotisations)
        ;

        $cotisationEnCours = null;
        if ($etablissement->getAdherent() != null)
        {
            $cotisationEnCours = $em
                ->getRepository('SNDLLPlatformBundle:Cotisation')
                ->getCotisationEnCours($etablissement->getAdherent()->getCodeAdherent());
        }

        return $this->render('SNDLLPlatformBundle:Etablissement:view.html.twig', array(
            'etablissement'         => $etablissement,
            'cotisations'           => $cotisations,
            'cotisationvalide'     => $cotisationEnCours,
        ));
    }

    public function addAction(Request $request)
    {
        $etablissement = new Etablissement();
        $form = $this->createForm(new EtablissementAddType(), $etablissement);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $etablissement->setDateDerniereModification(new \DateTime());
            $etatEtablissement = $em
                ->getRepository('SNDLLPlatformBundle:EtatEtablissement')
                ->getEtatEtablissementById(2);
            $etablissement->setEtatEtablissement($etatEtablissement);
            $em->persist($etablissement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'L\'établissement a bien été enregistré.');

            return $this->redirect($this->generateUrl('sndll_etablissement', array('eta_id' => $etablissement->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Etablissement:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function editAction(Etablissement $etablissement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }

        $form = $this->createForm(new EtablissementEditType(), $etablissement);

        if ($form->handleRequest($request)->isValid()) {
            $etablissement->setDateDerniereModification(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'L\'établissement a bien été modifié.');

            if ($etablissement->getAdherent() != null)
            {
                $this->container->get('wordpress_service')->majWordPress($etablissement->getAdherent(), $request);
            }

            return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $etablissement->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Etablissement:edit.html.twig', array(
            'form'   => $form->createView(),
            'etablissement' => $etablissement
        ));
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function deleteAction(Etablissement $etablissement, Request $request)
    {
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            if ($etablissement->getAdherent() != null)
            {
                $this->container->get('wordpress_service')->deleteUserWordPress($etablissement->getAdherent(), $request);
            }
            $em->remove($etablissement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "L'établissement a bien été supprimé.");

            return $this->redirect($this->generateUrl('sndll_etablissement'));
        }

        return $this->render('SNDLLPlatformBundle:Etablissement:delete.html.twig', array(
            'etablissement' => $etablissement,
            'form'   => $form->createView()
        ));
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function fichePrintAction(Etablissement $etablissement)
    {
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }

        $pageUrl = $this->generateUrl('sndll_etablissement_fiche_view', array('eta_id' => $etablissement->getId()), true);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="fiche-renseignement.pdf"'
            )
        );
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function ficheViewAction(Etablissement $etablissement)
    {
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $nombredecotisations = 5;
        $cotisations = $em
            ->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisationsByEtablissement($etablissement, $nombredecotisations)
        ;

        $cotisationEnCours = null;
        if ($etablissement->getAdherent() != null)
        {
            $cotisationEnCours = $em
                ->getRepository('SNDLLPlatformBundle:Cotisation')
                ->getCotisationEnCours($etablissement->getAdherent()->getCodeAdherent());
        }

        return $this->render('SNDLLPlatformBundle:Print/FicheRenseignement:ficherenseignement.html.twig', array(
            'etablissement'         => $etablissement,
            'cotisations'           => $cotisations,
            'cotisationvalide'      => $cotisationEnCours,
        ));
    }

    /**
     * @ParamConverter("adherent", options={"mapping": {"adh_code": "code_adherent"}})
     */
    public function majWordpressAction(Adherent $adherent, Request $request)
    {
        $this->container->get('wordpress_service')->majWordPress($adherent, $request);
        return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $adherent->getEtablissement()->getId())));
    }

    /**
     * @ParamConverter("adherent", options={"mapping": {"adh_code": "code_adherent"}})
     */
    public  function renewPasswordWordPressAction(Adherent $adherent, Request $request)
    {
        if ($adherent == null)
        {
            throw new \Exception("L'adhérent n'existe pas.");
        }

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid())
        {
            $this->container->get('wordpress_service')->renewPasswordWordpress($adherent, $request);
            return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $adherent->getEtablissement()->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Etablissement:renewPasswordConfirm.html.twig', array(
            'adherent' => $adherent,
            'form'   => $form->createView()
        ));
    }

    /**
     * @ParamConverter("adherent", options={"mapping": {"adh_code": "code_adherent"}})
     */
    public function majAction(Adherent $adherent, Request $request)
    {
        $this->container->get('wordpress_service')->majWordPress($adherent, $request);
        return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $adherent->getEtablissement()->getId())));
    }
}
