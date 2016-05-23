<?php

namespace SNDLL\PlatformBundle\Controller;

use SNDLL\PlatformBundle\Entity\Contact;
use SNDLL\PlatformBundle\Entity\Etablissement;
use SNDLL\PlatformBundle\Form\ContactAddType;
use SNDLL\PlatformBundle\Form\ContactEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SNDLL\PlatformBundle\Form\EtablissementAddType;
use SNDLL\PlatformBundle\Form\EtablissementEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ContactController extends Controller
{
    /**
     * @ParamConverter("etablissement", options={"mapping": {"eta_id": "id"}})
     */
    public function addAction(Etablissement $etablissement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $etablissement) {
            throw new \Exception("L'établissement n'existe pas.");
        }
        $contact = new Contact();
        $contact->setEtablissement($etablissement);
        $form = $this->createForm(new ContactAddType(), $contact);

        if ($form->handleRequest($request)->isValid()) {
            $contact->setDateDerniereModification(new \DateTime());
            $em->persist($contact);
            $em->flush();
            if ($contact->getRole()->getLibelle() == "Responsable")
            {
                $contact->getEtablissement()->setIdResponsable($contact->getId());
                $em->flush();
            }

            $request->getSession()->getFlashBag()->add('notice', 'Le contact a bien été enregistré.');

            return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $etablissement->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Contact:add.html.twig', array(
            'form'              => $form->createView(),
            'contact'           => $contact,
            'etablissement'     => $etablissement
        ));
    }

    /**
     * @ParamConverter("contact", options={"mapping": {"con_id": "id"}})
     */
    public function editAction(Contact $contact, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (null === $contact) {
            throw new \Exception("Le contact n'existe pas.");
        }

        $form = $this->createForm(new ContactEditType(), $contact);

        if ($form->handleRequest($request)->isValid()) {
            if ($contact->getRole()->getLibelle() == "Responsable")
            {
                $contact->getEtablissement()->setIdResponsable($contact->getId());
            }
            elseif($contact->getEtablissement()->getIdResponsable() == $contact->getId())
            {
                $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                    ->getAutreResponsable($contact->getEtablissement()->getId(), $contact->getId());
                if ($responsable != null)
                    $contact->getEtablissement()->setIdResponsable($responsable->getId());
                else
                    $contact->getEtablissement()->setIdResponsable(null);
            }
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le contact a bien été modifié.');

            return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $contact->getEtablissement()->getId())));
        }

        return $this->render('SNDLLPlatformBundle:Contact:edit.html.twig', array(
            'form'   => $form->createView(),
            'contact' => $contact
        ));
    }

    /**
     * @ParamConverter("contact", options={"mapping": {"con_id": "id"}})
     */
    public function deleteAction(Contact $contact, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $contact) {
            throw new \Exception("Le contact n'existe pas.");
        }

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $idEtablissement = $contact->getEtablissement()->getId();
            if ($contact->getRole()->getLibelle() == "Responsable" AND $contact->getEtablissement()->getIdResponsable() == $contact->getId())
            {
                $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                    ->getAutreResponsable($contact->getEtablissement()->getId(), $contact->getId());
                if ($responsable != null)
                    $contact->getEtablissement()->setIdResponsable($responsable->getId());
                else
                    $contact->getEtablissement()->setIdResponsable(null);
            }
            $em->remove($contact);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', "Le contact a bien été supprimé.");

            return $this->redirect($this->generateUrl('sndll_etablissement_view', array('eta_id' => $idEtablissement)));
        }

        return $this->render('SNDLLPlatformBundle:Contact:delete.html.twig', array(
            'contact' => $contact,
            'form'   => $form->createView()
        ));
    }
}
