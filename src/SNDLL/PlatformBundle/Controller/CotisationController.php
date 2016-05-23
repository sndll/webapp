<?php

namespace SNDLL\PlatformBundle\Controller;


use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\Cotisation;
use SNDLL\PlatformBundle\Entity\Adherent;
use SNDLL\PlatformBundle\Entity\TypeAdhesion;
use SNDLL\PlatformBundle\Form\TypeAdhesionAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use SNDLL\PlatformBundle\Form\CotisationAddType;
use SNDLL\PlatformBundle\Form\CotisationEditType;
use SNDLL\PlatformBundle\Form\CotisationAddWithEtablissementType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;

class CotisationController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNDLLPlatformBundle:Cotisation:index.html.twig');
    }

    public function indexJsonAction()
    {
        $conn = $this->get('database_connection');
        $cotisations = $conn->fetchAll('SELECT cotisations.id, code_adherent, types_adhesions.libelle, date_debut, date_fin FROM cotisations INNER JOIN types_adhesions ON type_adhesion_id = types_adhesions.id');

        $table = $cotisations;

        $response = new JsonResponse();
        $response->setData($table);
        return $response;
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function viewAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        return $this->render('SNDLLPlatformBundle:Cotisation:view.html.twig', array(
            'cotisation'           => $cotisation
        ));
    }

    public function addAction(Request $request)
    {
        $cotisation = new Cotisation();
        $form = $this->createForm(new CotisationAddType(), $cotisation);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cotisation);
            $em->flush();

            if ($cotisation->getAdherent()->getDatePremiereCotisation() == null)
                $cotisation->getAdherent()->setDatePremiereCotisation(new \DateTime());
            $cotisation->getAdherent()->setIdDerniereCotisation($cotisation->getId());
            $cotisation->getAdherent()->setDateDerniereModification(new \DateTime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La cotisation a bien été enregistrée.');

            $this->container->get('wordpress_service')->majWordPress($cotisation->getAdherent(), $request);

            return $this->redirect($this->generateUrl('sndll_cotisation', array('cot_id' => $cotisation->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Cotisation:add.html.twig', array(
            'form'              => $form->createView()
        ));
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function addWithEtablissementAction(Etablissement $etablissement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $etablissement) {
            throw new NotFoundHttpException("L'établissement n'existe pas.");
        }

        $cotisation = new Cotisation();
        $form = $this->createForm(new CotisationAddWithEtablissementType(), $cotisation);

        if ($form->handleRequest($request)->isValid())
        {
            if ($etablissement->getAdherent() == null)
            {
                $adherent = new Adherent($em, $etablissement);
                $em->persist($adherent);
                $etablissement->setAdherent($adherent);
                $em->flush();
            }

            $cotisation->setAdherent($etablissement->getAdherent());
            $em->persist($cotisation);
            $em->flush();

            if ($cotisation->getAdherent()->getDatePremiereCotisation() == null)
                $cotisation->getAdherent()->setDatePremiereCotisation(new \DateTime());
            $cotisation->getAdherent()->setIdDerniereCotisation($cotisation->getId());
            $cotisation->getAdherent()->setDateDerniereModification(new \DateTime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'La cotisation a bien été enregistrée.');

            $this->container->get('wordpress_service')->majWordPress($cotisation->getAdherent(), $request);

            return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $etablissement->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Cotisation:add.html.twig', array(
            'form'              => $form->createView(),
            'etablissement' => $etablissement
        ));
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function editAction(Cotisation $cotisation, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $cotisation) {
            throw new NotFoundHttpException("La cotisation n'existe pas.");
        }

        $form = $this->createForm(new CotisationEditType(), $cotisation);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'La cotisation a bien été modifiée.');

            $this->container->get('wordpress_service')->majWordPress($cotisation->getAdherent(), $request);

            return $this->redirect($this->generateUrl('sndll_cotisation_view', array('cot_id' => $cotisation->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Cotisation:edit.html.twig', array(
            'form'   => $form->createView(),
            'cotisation' => $cotisation
        ));
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function deleteAction(Cotisation $cotisation, Request $request)
    {
        if (null === $cotisation) {
            throw new NotFoundHttpException("La cotisation n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $adherent = $cotisation->getAdherent();
            $em->remove($cotisation);
            $em->flush();

            $derniereCotisation = $em->getRepository('SNDLLPlatformBundle:Cotisation')
                ->getDerniereCotisation($adherent->getCodeAdherent());
            if ($derniereCotisation != null)
            {
                $adherent->setIdDerniereCotisation($derniereCotisation->getId());
            }else{
                $adherent->setIdDerniereCotisation(null);
            }

            $adherent->setDateDerniereModification(new \DateTime());
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "La cotisation a bien été supprimée.");

            $this->container->get('wordpress_service')->majWordPress($adherent, $request);

            return $this->redirect($this->generateUrl('sndll_cotisation'));
        }

        return $this->render('SNDLLPlatformBundle:Cotisation:delete.html.twig', array(
            'cotisation' => $cotisation,
            'form'   => $form->createView()
        ));
    }

    public function indexTypeAdhesionAction()
    {
        $listeTypeAdhesion = $this->getDoctrine()
            ->getManager()
            ->getRepository('SNDLLPlatformBundle:TypeAdhesion')
            ->getTypesAdhesions()
        ;

        return $this->render('SNDLLPlatformBundle:Cotisation/TypeAdhesion:index.html.twig', array(
            'listeTypeAdhesion' => $listeTypeAdhesion
        ));
    }

    public function addTypeAdhesionAction(Request $request)
    {
        $typeAdhesion = new TypeAdhesion();
        $form = $this->createForm(new TypeAdhesionAddType(), $typeAdhesion);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeAdhesion);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le nouveau type d\'adhésion a bien été ajouté.');

            return $this->redirect($this->generateUrl('sndll_typeadhesion'));
        }

        return $this->render('SNDLLPlatformBundle:Cotisation/TypeAdhesion:add.html.twig', array(
            'form'              => $form->createView()
        ));
    }

    /**
     * @ParamConverter("typeAdhesion", options={"mapping": {"ta_id": "id"}})
     */
    public function deleteTypeAdhesionAction(TypeAdhesion $typeAdhesion, Request $request)
    {
        if (null === $typeAdhesion) {
            throw new NotFoundHttpException("Le type d'adhésion n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($typeAdhesion);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "Le type d'adhésion a bien été supprimé.");

            return $this->redirect($this->generateUrl('sndll_typeadhesion'));
        }

        return $this->render('SNDLLPlatformBundle:Cotisation/TypeAdhesion:delete.html.twig', array(
            'typeadhesion' => $typeAdhesion,
            'form'   => $form->createView()
        ));
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function facturePrintAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        $pageUrl = $this->generateUrl('sndll_cotisation_facture_view', array('cot_id' => $cotisation->getId()), true);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="facture.pdf"'
            )
        );
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function factureViewAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        return $this->render('SNDLLPlatformBundle:Print/Facture:facture.html.twig', array(
            'cotisation'         => $cotisation,
        ));
    }

}
