<?php

namespace SNDLL\PlatformBundle\Controller;

use SNDLL\PlatformBundle\Entity\Cotisation;
use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Entity\Export;
use SNDLL\PlatformBundle\Entity\Sacem;
use SNDLL\PlatformBundle\Entity\Spre;
use SNDLL\PlatformBundle\Form\ExportType;
use SNDLL\PlatformBundle\Form\SacemAddType;
use SNDLL\PlatformBundle\Form\SacemEditType;
use SNDLL\PlatformBundle\Form\SpreEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class OGCController extends Controller
{
    public function indexAction()
    {
        return $this->render('SNDLLPlatformBundle:OGC:index.html.twig');
    }

    public function indexSacemAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listeSacem = $em
            ->getRepository('SNDLLPlatformBundle:Sacem')
            ->getCentresSACEM()
        ;

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:index.html.twig', array(
            'listeSacem' => $listeSacem
        ));
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function selectSacemAction(Etablissement $etablissement)
    {
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $listeSacem = $em
            ->getRepository('SNDLLPlatformBundle:Sacem')
            ->getCentresSACEM()
        ;

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:select.html.twig', array(
            'listeSacem'    => $listeSacem,
            'etablissement' => $etablissement
        ));
    }

    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     * @ParamConverter("sacem", options={"mapping": {"sacem_id": "code_sacem"}})
     */
    public function assocSacemEtablissementAction(Etablissement $etablissement, Sacem $sacem, Request $request)
    {
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }
        if (null === $sacem) {
            throw new \Exception("Le centre Sacem n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();
        $etablissement->setDateDerniereModification(new \DateTime());
        $etablissement->setSacem($sacem);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Le changement de centre Sacem a bien été enregistré pour cet établissement.');

        return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $etablissement->getId())));
    }

    public function addSacemAction(Request $request)
    {
        $sacem = new Sacem();
        $form = $this->createForm(new SacemAddType(), $sacem);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $sacem->setDateDerniereModification(new \DateTime());
            $em->persist($sacem);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le nouveau centre Sacem a bien été enregistré.');

            return $this->redirect($this->generateUrl('sndll_ogc_sacem'));
        }

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:add.html.twig', array(
            'form'              => $form->createView()
        ));
    }

    /**
     * @ParamConverter("sacem", options={"mapping": {"sacem_id": "code_sacem"}})
     */
    public function viewSacemAction(Sacem $sacem)
    {
        if (null === $sacem) {
            throw new \Exception("Le centre Sacem n'existe pas.");
        }

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:view.html.twig', array(
            'sacem'           => $sacem
        ));
    }

    /**
     * @ParamConverter("sacem", options={"mapping": {"sacem_id": "code_sacem"}})
     */
    public function editSacemAction(Sacem $sacem, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $sacem) {
            throw new \Exception("Le centre Spre n'existe pas.");
        }

        $form = $this->createForm(new SacemEditType(), $sacem);

        if ($form->handleRequest($request)->isValid()) {
            $sacem->setDateDerniereModification(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'La fiche d\'information du centre Sacem à bien été modifiée.');

            return $this->redirect($this->generateUrl('sndll_ogc_sacem_view', array('sacem_id' => $sacem->getCodeSacem())));
        }

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:edit.html.twig', array(
            'form'   => $form->createView(),
            'sacem' => $sacem
        ));
    }

    /**
     * @ParamConverter("sacem", options={"mapping": {"sacem_id": "code_sacem"}})
     */
    public function deleteSacemAction(Sacem $sacem, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $sacem) {
            throw new \Exception("Le centre sacem n'existe pas.");
        }

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($sacem);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "Le centre Sacem a bien été supprimé.");

            return $this->redirect($this->generateUrl('sndll_ogc_sacem'));
        }

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:delete.html.twig', array(
            'sacem' => $sacem,
            'form'   => $form->createView()
        ));
    }

    /**
     * @ParamConverter("spre", options={"mapping": {"spre_id": "id"}})
     */
    public function viewSpreAction(Spre $spre)
    {
        if (null === $spre) {
            throw new \Exception("Le centre Spre n'existe pas.");
        }

        return $this->render('SNDLLPlatformBundle:OGC/Spre:view.html.twig', array(
            'spre'           => $spre
        ));
    }

    /**
     * @ParamConverter("spre", options={"mapping": {"spre_id": "id"}})
     */
    public function editSpreAction(Spre $spre, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $spre) {
            throw new \Exception("Le centre Spre n'existe pas.");
        }

        $form = $this->createForm(new SpreEditType(), $spre);

        if ($form->handleRequest($request)->isValid()) {
            $spre->setDateDerniereModification(new \DateTime());
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'La fiche d\'information du centre Spre bien été modifiée.');

            return $this->redirect($this->generateUrl('sndll_ogc_spre_view'));
        }

        return $this->render('SNDLLPlatformBundle:OGC/Spre:edit.html.twig', array(
            'form'   => $form->createView(),
            'spre' => $spre
        ));
    }

    public function exportCertificatsSacemAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $export = new Export();

        $form = $this->createForm(new ExportType(), $export);

        if ($form->handleRequest($request)->isValid()) {
            $listeCotisations = $em
                ->getRepository('SNDLLPlatformBundle:Cotisation')
                ->getCotisationsByDateReglement($export->getDateDebut(), $export->getDateFin());

            if ($listeCotisations == null)
            {
                $request->getSession()->getFlashBag()->add('danger', 'Aucune cotisation a été trouvée dans la plage recherchée.');

                return $this->render('SNDLLPlatformBundle:OGC/Sacem:exportCertificats.html.twig', array(
                    'form'   => $form->createView(),
                    'export' => $export
                ));
            }

            foreach ($listeCotisations as $cotisation)
            {
                $listeURL[] = $this->generateUrl('sndll_ogc_certificat_sacem_view', array('cot_id' => $cotisation->getId()), true);
            }
            return new Response(
                $this->get('knp_snappy.pdf')->getOutput($listeURL),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="adhesions-sacem.pdf"'
                )
            );
        }

        return $this->render('SNDLLPlatformBundle:OGC/Sacem:exportCertificats.html.twig', array(
            'form'   => $form->createView(),
            'export' => $export
        ));
    }

    public function exportCertificatsSpreAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $export = new Export();

        $form = $this->createForm(new ExportType(), $export);

        if ($form->handleRequest($request)->isValid()) {
            $listeCotisations = $em
                ->getRepository('SNDLLPlatformBundle:Cotisation')
                ->getCotisationsByDateReglement($export->getDateDebut(), $export->getDateFin());

            if ($listeCotisations == null)
            {
                $request->getSession()->getFlashBag()->add('danger', 'Aucune cotisation a été trouvée dans la plage recherchée.');

                return $this->render('SNDLLPlatformBundle:OGC/Spre:exportCertificats.html.twig', array(
                    'form'   => $form->createView(),
                    'export' => $export
                ));
            }

            foreach ($listeCotisations as $cotisation)
            {
                $listeURL[] = $this->generateUrl('sndll_ogc_certificat_spre_view', array('cot_id' => $cotisation->getId()), true);
            }
            return new Response(
                $this->get('knp_snappy.pdf')->getOutput($listeURL),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="adhesions-spre.pdf"'
                )
            );
        }

        return $this->render('SNDLLPlatformBundle:OGC/Spre:exportCertificats.html.twig', array(
            'form'   => $form->createView(),
            'export' => $export
        ));
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function certificatSacemPrintAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        $pageUrl = $this->generateUrl('sndll_ogc_certificat_sacem_view', array('cot_id' => $cotisation->getId()), true);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="adhesion-sacem.pdf"'
            )
        );
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function certificatSacemViewAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        if ($cotisation->getAdherent()->getEtablissement()->getSacem() == null) {
            throw new \Exception("La cotisation n'est liée à aucun centre sacem.");
        }

        $responsable = $em
            ->getRepository('SNDLLPlatformBundle:Contact')
            ->getResponsable($cotisation->getAdherent()->getEtablissement()->getId());

        return $this->render('SNDLLPlatformBundle:Print/Certificat/Sacem:certificat.html.twig', array(
            'etablissement'         => $cotisation->getAdherent()->getEtablissement(),
            'responsable'           => $responsable,
            'cotisationvalide'      => $cotisation,
        ));
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function certificatSprePrintAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        $pageUrl = $this->generateUrl('sndll_ogc_certificat_spre_view', array('cot_id' => $cotisation->getId()), true);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="adhesion-sacem.pdf"'
            )
        );
    }

    /**
     * @ParamConverter("cotisation", options={"mapping": {"cot_id": "id"}})
     */
    public function certificatSpreViewAction(Cotisation $cotisation)
    {
        if (null === $cotisation) {
            throw new \Exception("La cotisation n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $responsable = $em
            ->getRepository('SNDLLPlatformBundle:Contact')
            ->getResponsable($cotisation->getAdherent()->getEtablissement()->getId());

        $spre = $em
            ->getRepository('SNDLLPlatformBundle:Spre')
            ->getSpre();

        return $this->render('SNDLLPlatformBundle:Print/Certificat/Spre:certificat.html.twig', array(
            'etablissement'         => $cotisation->getAdherent()->getEtablissement(),
            'responsable'           => $responsable,
            'cotisationvalide'      => $cotisation,
            'spre'                  => $spre,
        ));
    }
}
