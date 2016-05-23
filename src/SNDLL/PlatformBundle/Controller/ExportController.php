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

class ExportController extends Controller
{
    public function exportAllEtablissementsAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Etablissement')
                ->exportAllEtablissementsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Enseigne',
                'Forme Jurdique',
                'Nom Juridique',
                'Site Internet',
                'Code SIRET',
                'Code APE',
                'Nombre Salariés',
                'Capacité',
                'Adresse Etablissement Rue',
                'Adresse Etablissement Code Postal',
                'Adresse Etablissement Ville',
                'Adresse Etablissement Informations Complémentaires',
                'Etablissement Téléphone Principal',
                'Etablissement Téléphone Secondaire',
                'Etablissement Fax',
                'Etablissement Email',
                'Etablissement Autorisation Coordonnées',
                'Code Adhérent',
                'Etat Cotisation',
                'Civilité Responsable',
                'Nom Responsable',
                'Prénom Responsable',
                'Adresse Responsable Rue',
                'Adresse Responsable Code Postal',
                'Adresse Responsable Ville',
                'Adresse Responsable Informations Complémentaires',
                'Responsable Téléphone Principal',
                'Responsable Téléphone Secondaire',
                'Responsable Fax',
                'Responsable Email',
                'Responsable Autorisation Coordonnées',
                'Centre Sacem',
                'Civilite Responsable Centre Sacem',
                'Nom Responsable Centre Sacem',
                'Prénom Responsable Centre Sacem',
                'Adresse Centre Sacem Rue',
                'Adresse Centre Sacem Code Postal',
                'Adresse Centre Sacem Ville',
                'Adresse Centre Sacem Informations Complémentaires',
                'Centre Sacem Téléphone Principal',
                'Centre Sacem Fax',
                'Centre Sacem Email',
                'Login Site',
                'Mdp Site'
            )), ';');

            while (false !== ($row = $results->next())) {

                $cotisationEnCours = null;
                $codeadherent = null;
                $loginSite = null;
                $mdpSite = null;
                if ($row[0]->getAdherent() != null)
                {
                    $cotisationEnCours = $em->getRepository('SNDLLPlatformBundle:Cotisation')->getCotisationEnCours($row[0]->getAdherent()->getCodeAdherent());
                    $codeadherent = $row[0]->getAdherent()->getCodeAdherent();
                    if ($row[0]->getAdherent()->getIdentifiants() != null)
                    {
                        $loginSite = $row[0]->getAdherent()->getIdentifiants()->getLoginWP();
                        $mdpSite = $row[0]->getAdherent()->getIdentifiants()->getPasswordWP();
                    }
                }
                $etatCotisation = null;
                if ($cotisationEnCours == null)
                    $etatCotisation = 'Pas de cotisation à jour';
                else
                    $etatCotisation = 'Cotisation à jour';

                $civiliteResponsable = null;
                $nomResponsable = null;
                $prenomResponsable = null;
                $rueResponsable = null;
                $codePostalResponsable = null;
                $villeResponsable = null;
                $informationsComplementairesResponsable = null;
                $telephonePrincipalResponsable = null;
                $telephoneSecondaireResponsable = null;
                $faxResponsable = null;
                $emailResponsable = null;
                $autorisationCoordonneesResponsable = null;
                $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                    ->getResponsable($row[0]->getId());
                if ($responsable != null)
                {
                    if ($responsable->getCivilite() != null)
                    {
                        $civiliteResponsable = $responsable->getCivilite()->getLibelle();
                    }
                    $nomResponsable = $responsable->getNom();
                    $prenomResponsable = $responsable->getPrenom();
                    if ($responsable->getCoordonnees() != null)
                    {
                        $rueResponsable = $responsable->getCoordonnees()->getAdresse();
                        $codePostalResponsable = $responsable->getCoordonnees()->getCodePostal();
                        $villeResponsable = $responsable->getCoordonnees()->getVille();
                        $informationsComplementairesResponsable = $responsable->getCoordonnees()->getInformationsComplementaires();
                        $telephonePrincipalResponsable = $responsable->getCoordonnees()->getTelephonePrincipal();
                        $telephoneSecondaireResponsable = $responsable->getCoordonnees()->getTelephoneSecondaire();
                        $faxResponsable = $responsable->getCoordonnees()->getFax();
                        $emailResponsable = $responsable->getCoordonnees()->getEmail();
                        $autorisationCoordonneesResponsable = $responsable->getCoordonnees()->getAutorisation()->getLibelle();
                    }
                }

                $libelleSacem = null;
                $civiliteResponsableSacem = null;
                $nomResponsableSacem = null;
                $prenomResponsableSacem = null;
                $rueSacem = null;
                $codePostalSacem = null;
                $villeSacem = null;
                $informationsComplementairesSacem = null;
                $telephonePrincipalSacem = null;
                $faxSacem = null;
                $emailSacem = null;
                if ($row[0]->getSacem() != null)
                {
                    $libelleSacem = $row[0]->getSacem()->getLibelle();
                    $civiliteResponsableSacem = $row[0]->getSacem()->getCivilite()->getLibelle();
                    $nomResponsableSacem = $row[0]->getSacem()->getNomResponsable();
                    $prenomResponsableSacem = $row[0]->getSacem()->getPrenomResponsable();
                    $rueSacem = $row[0]->getSacem()->getCoordonnees()->getAdresse();
                    $codePostalSacem = $row[0]->getSacem()->getCoordonnees()->getCodePostal();
                    $villeSacem = $row[0]->getSacem()->getCoordonnees()->getVille();
                    $informationsComplementairesSacem = $row[0]->getSacem()->getCoordonnees()->getInformationsComplementaires();
                    $telephonePrincipalSacem = $row[0]->getSacem()->getCoordonnees()->getTelephonePrincipal();
                    $faxSacem = $row[0]->getSacem()->getCoordonnees()->getFax();
                    $emailSacem = $row[0]->getSacem()->getCoordonnees()->getEmail();
                }

                fputcsv($handle, $this->iso_converter(array(
                    $row[0]->getId(),
                    $row[0]->getEnseigne(),
                    $row[0]->getFormeJuridique()->getLibelle(),
                    $row[0]->getNomJuridique(),
                    $row[0]->getSiteInternet(),
                    $row[0]->getCodeSiret(),
                    $row[0]->getCodeAPE()->getCodeAPE(),
                    $row[0]->getNombreSalaries(),
                    $row[0]->getCapacite()->getLibelle(),
                    $row[0]->getCoordonnees()->getAdresse(),
                    $row[0]->getCoordonnees()->getCodePostal(),
                    $row[0]->getCoordonnees()->getVille(),
                    $row[0]->getCoordonnees()->getInformationsComplementaires(),
                    $row[0]->getCoordonnees()->getTelephonePrincipal(),
                    $row[0]->getCoordonnees()->getTelephoneSecondaire(),
                    $row[0]->getCoordonnees()->getFax(),
                    $row[0]->getCoordonnees()->getEmail(),
                    $row[0]->getCoordonnees()->getAutorisation()->getLibelle(),
                    $codeadherent,
                    $etatCotisation,
                    $civiliteResponsable,
                    $nomResponsable,
                    $prenomResponsable,
                    $rueResponsable,
                    $codePostalResponsable,
                    $villeResponsable,
                    $informationsComplementairesResponsable,
                    $telephonePrincipalResponsable,
                    $telephoneSecondaireResponsable,
                    $faxResponsable,
                    $emailResponsable,
                    $autorisationCoordonneesResponsable,
                    $libelleSacem,
                    $civiliteResponsableSacem,
                    $nomResponsableSacem,
                    $prenomResponsableSacem,
                    $rueSacem,
                    $codePostalSacem,
                    $villeSacem,
                    $informationsComplementairesSacem,
                    $telephonePrincipalSacem,
                    $faxSacem,
                    $emailSacem,
                    $loginSite,
                    $mdpSite,
                )), ';');
                $em->detach($row[0]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }

    public function exportEtablissementsActuellementAdherentsAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Etablissement')
                ->exportAllEtablissementsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Enseigne',
                'Forme Jurdique',
                'Nom Juridique',
                'Site Internet',
                'Code SIRET',
                'Code APE',
                'Nombre Salariés',
                'Capacité',
                'Adresse Etablissement Rue',
                'Adresse Etablissement Code Postal',
                'Adresse Etablissement Ville',
                'Adresse Etablissement Informations Complémentaires',
                'Etablissement Téléphone Principal',
                'Etablissement Téléphone Secondaire',
                'Etablissement Fax',
                'Etablissement Email',
                'Etablissement Autorisation Coordonnées',
                'Code Adhérent',
                'Etat Cotisation',
                'Civilité Responsable',
                'Nom Responsable',
                'Prénom Responsable',
                'Adresse Responsable Rue',
                'Adresse Responsable Code Postal',
                'Adresse Responsable Ville',
                'Adresse Responsable Informations Complémentaires',
                'Responsable Téléphone Principal',
                'Responsable Téléphone Secondaire',
                'Responsable Fax',
                'Responsable Email',
                'Responsable Autorisation Coordonnées',
                'Centre Sacem',
                'Civilite Responsable Centre Sacem',
                'Nom Responsable Centre Sacem',
                'Prénom Responsable Centre Sacem',
                'Adresse Centre Sacem Rue',
                'Adresse Centre Sacem Code Postal',
                'Adresse Centre Sacem Ville',
                'Adresse Centre Sacem Informations Complémentaires',
                'Centre Sacem Téléphone Principal',
                'Centre Sacem Fax',
                'Centre Sacem Email',
                'Login Site',
                'Mdp Site'
            )), ';');

            while (false !== ($row = $results->next())) {

                $cotisationEnCours = null;
                $codeadherent = null;
                $loginSite = null;
                $mdpSite = null;
                if ($row[0]->getAdherent() != null)
                {
                    $cotisationEnCours = $em->getRepository('SNDLLPlatformBundle:Cotisation')->getCotisationEnCours($row[0]->getAdherent()->getCodeAdherent());
                    $codeadherent = $row[0]->getAdherent()->getCodeAdherent();
                    if ($row[0]->getAdherent()->getIdentifiants() != null)
                    {
                        $loginSite = $row[0]->getAdherent()->getIdentifiants()->getLoginWP();
                        $mdpSite = $row[0]->getAdherent()->getIdentifiants()->getPasswordWP();
                    }
                }
                if ($cotisationEnCours != null)
                {
                    $etatCotisation = null;
                    if ($cotisationEnCours == null)
                        $etatCotisation = 'Pas de cotisation à jour';
                    else
                        $etatCotisation = 'Cotisation à jour';

                    $civiliteResponsable = null;
                    $nomResponsable = null;
                    $prenomResponsable = null;
                    $rueResponsable = null;
                    $codePostalResponsable = null;
                    $villeResponsable = null;
                    $informationsComplementairesResponsable = null;
                    $telephonePrincipalResponsable = null;
                    $telephoneSecondaireResponsable = null;
                    $faxResponsable = null;
                    $emailResponsable = null;
                    $autorisationCoordonneesResponsable = null;
                    $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                        ->getResponsable($row[0]->getId());
                    if ($responsable != null)
                    {
                        if ($responsable->getCivilite() != null)
                        {
                            $civiliteResponsable = $responsable->getCivilite()->getLibelle();
                        }
                        $nomResponsable = $responsable->getNom();
                        $prenomResponsable = $responsable->getPrenom();
                        if ($responsable->getCoordonnees() != null)
                        {
                            $rueResponsable = $responsable->getCoordonnees()->getAdresse();
                            $codePostalResponsable = $responsable->getCoordonnees()->getCodePostal();
                            $villeResponsable = $responsable->getCoordonnees()->getVille();
                            $informationsComplementairesResponsable = $responsable->getCoordonnees()->getInformationsComplementaires();
                            $telephonePrincipalResponsable = $responsable->getCoordonnees()->getTelephonePrincipal();
                            $telephoneSecondaireResponsable = $responsable->getCoordonnees()->getTelephoneSecondaire();
                            $faxResponsable = $responsable->getCoordonnees()->getFax();
                            $emailResponsable = $responsable->getCoordonnees()->getEmail();
                            $autorisationCoordonneesResponsable = $responsable->getCoordonnees()->getAutorisation()->getLibelle();
                        }
                    }

                    $libelleSacem = null;
                    $civiliteResponsableSacem = null;
                    $nomResponsableSacem = null;
                    $prenomResponsableSacem = null;
                    $rueSacem = null;
                    $codePostalSacem = null;
                    $villeSacem = null;
                    $informationsComplementairesSacem = null;
                    $telephonePrincipalSacem = null;
                    $faxSacem = null;
                    $emailSacem = null;
                    if ($row[0]->getSacem() != null)
                    {
                        $libelleSacem = $row[0]->getSacem()->getLibelle();
                        $civiliteResponsableSacem = $row[0]->getSacem()->getCivilite()->getLibelle();
                        $nomResponsableSacem = $row[0]->getSacem()->getNomResponsable();
                        $prenomResponsableSacem = $row[0]->getSacem()->getPrenomResponsable();
                        $rueSacem = $row[0]->getSacem()->getCoordonnees()->getAdresse();
                        $codePostalSacem = $row[0]->getSacem()->getCoordonnees()->getCodePostal();
                        $villeSacem = $row[0]->getSacem()->getCoordonnees()->getVille();
                        $informationsComplementairesSacem = $row[0]->getSacem()->getCoordonnees()->getInformationsComplementaires();
                        $telephonePrincipalSacem = $row[0]->getSacem()->getCoordonnees()->getTelephonePrincipal();
                        $faxSacem = $row[0]->getSacem()->getCoordonnees()->getFax();
                        $emailSacem = $row[0]->getSacem()->getCoordonnees()->getEmail();
                    }

                    fputcsv($handle, $this->iso_converter(array(
                        $row[0]->getId(),
                        $row[0]->getEnseigne(),
                        $row[0]->getFormeJuridique()->getLibelle(),
                        $row[0]->getNomJuridique(),
                        $row[0]->getSiteInternet(),
                        $row[0]->getCodeSiret(),
                        $row[0]->getCodeAPE()->getCodeAPE(),
                        $row[0]->getNombreSalaries(),
                        $row[0]->getCapacite()->getLibelle(),
                        $row[0]->getCoordonnees()->getAdresse(),
                        $row[0]->getCoordonnees()->getCodePostal(),
                        $row[0]->getCoordonnees()->getVille(),
                        $row[0]->getCoordonnees()->getInformationsComplementaires(),
                        $row[0]->getCoordonnees()->getTelephonePrincipal(),
                        $row[0]->getCoordonnees()->getTelephoneSecondaire(),
                        $row[0]->getCoordonnees()->getFax(),
                        $row[0]->getCoordonnees()->getEmail(),
                        $row[0]->getCoordonnees()->getAutorisation()->getLibelle(),
                        $codeadherent,
                        $etatCotisation,
                        $civiliteResponsable,
                        $nomResponsable,
                        $prenomResponsable,
                        $rueResponsable,
                        $codePostalResponsable,
                        $villeResponsable,
                        $informationsComplementairesResponsable,
                        $telephonePrincipalResponsable,
                        $telephoneSecondaireResponsable,
                        $faxResponsable,
                        $emailResponsable,
                        $autorisationCoordonneesResponsable,
                        $libelleSacem,
                        $civiliteResponsableSacem,
                        $nomResponsableSacem,
                        $prenomResponsableSacem,
                        $rueSacem,
                        $codePostalSacem,
                        $villeSacem,
                        $informationsComplementairesSacem,
                        $telephonePrincipalSacem,
                        $faxSacem,
                        $emailSacem,
                        $loginSite,
                        $mdpSite,
                    )), ';');
                }

                $em->detach($row[0]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }

    public function exportEtablissementsActuellementNonAdherentsAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Etablissement')
                ->exportAllEtablissementsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Enseigne',
                'Forme Jurdique',
                'Nom Juridique',
                'Site Internet',
                'Code SIRET',
                'Code APE',
                'Nombre Salariés',
                'Capacité',
                'Adresse Etablissement Rue',
                'Adresse Etablissement Code Postal',
                'Adresse Etablissement Ville',
                'Adresse Etablissement Informations Complémentaires',
                'Etablissement Téléphone Principal',
                'Etablissement Téléphone Secondaire',
                'Etablissement Fax',
                'Etablissement Email',
                'Etablissement Autorisation Coordonnées',
                'Code Adhérent',
                'Etat Cotisation',
                'Civilité Responsable',
                'Nom Responsable',
                'Prénom Responsable',
                'Adresse Responsable Rue',
                'Adresse Responsable Code Postal',
                'Adresse Responsable Ville',
                'Adresse Responsable Informations Complémentaires',
                'Responsable Téléphone Principal',
                'Responsable Téléphone Secondaire',
                'Responsable Fax',
                'Responsable Email',
                'Responsable Autorisation Coordonnées',
                'Centre Sacem',
                'Civilite Responsable Centre Sacem',
                'Nom Responsable Centre Sacem',
                'Prénom Responsable Centre Sacem',
                'Adresse Centre Sacem Rue',
                'Adresse Centre Sacem Code Postal',
                'Adresse Centre Sacem Ville',
                'Adresse Centre Sacem Informations Complémentaires',
                'Centre Sacem Téléphone Principal',
                'Centre Sacem Fax',
                'Centre Sacem Email',
                'Login Site',
                'Mdp Site'
            )), ';');

            while (false !== ($row = $results->next())) {

                $cotisationEnCours = null;
                $codeadherent = null;
                $loginSite = null;
                $mdpSite = null;
                if ($row[0]->getAdherent() != null)
                {
                    $cotisationEnCours = $em->getRepository('SNDLLPlatformBundle:Cotisation')->getCotisationEnCours($row[0]->getAdherent()->getCodeAdherent());
                    $codeadherent = $row[0]->getAdherent()->getCodeAdherent();
                    if ($row[0]->getAdherent()->getIdentifiants() != null)
                    {
                        $loginSite = $row[0]->getAdherent()->getIdentifiants()->getLoginWP();
                        $mdpSite = $row[0]->getAdherent()->getIdentifiants()->getPasswordWP();
                    }
                }
                if ($cotisationEnCours == null)
                {
                    $etatCotisation = null;
                    if ($cotisationEnCours == null)
                        $etatCotisation = 'Pas de cotisation à jour';
                    else
                        $etatCotisation = 'Cotisation à jour';

                    $civiliteResponsable = null;
                    $nomResponsable = null;
                    $prenomResponsable = null;
                    $rueResponsable = null;
                    $codePostalResponsable = null;
                    $villeResponsable = null;
                    $informationsComplementairesResponsable = null;
                    $telephonePrincipalResponsable = null;
                    $telephoneSecondaireResponsable = null;
                    $faxResponsable = null;
                    $emailResponsable = null;
                    $autorisationCoordonneesResponsable = null;
                    $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                        ->getResponsable($row[0]->getId());
                    if ($responsable != null)
                    {
                        if ($responsable->getCivilite() != null)
                        {
                            $civiliteResponsable = $responsable->getCivilite()->getLibelle();
                        }
                        $nomResponsable = $responsable->getNom();
                        $prenomResponsable = $responsable->getPrenom();
                        if ($responsable->getCoordonnees() != null)
                        {
                            $rueResponsable = $responsable->getCoordonnees()->getAdresse();
                            $codePostalResponsable = $responsable->getCoordonnees()->getCodePostal();
                            $villeResponsable = $responsable->getCoordonnees()->getVille();
                            $informationsComplementairesResponsable = $responsable->getCoordonnees()->getInformationsComplementaires();
                            $telephonePrincipalResponsable = $responsable->getCoordonnees()->getTelephonePrincipal();
                            $telephoneSecondaireResponsable = $responsable->getCoordonnees()->getTelephoneSecondaire();
                            $faxResponsable = $responsable->getCoordonnees()->getFax();
                            $emailResponsable = $responsable->getCoordonnees()->getEmail();
                            $autorisationCoordonneesResponsable = $responsable->getCoordonnees()->getAutorisation()->getLibelle();
                        }
                    }

                    $libelleSacem = null;
                    $civiliteResponsableSacem = null;
                    $nomResponsableSacem = null;
                    $prenomResponsableSacem = null;
                    $rueSacem = null;
                    $codePostalSacem = null;
                    $villeSacem = null;
                    $informationsComplementairesSacem = null;
                    $telephonePrincipalSacem = null;
                    $faxSacem = null;
                    $emailSacem = null;
                    if ($row[0]->getSacem() != null)
                    {
                        $libelleSacem = $row[0]->getSacem()->getLibelle();
                        $civiliteResponsableSacem = $row[0]->getSacem()->getCivilite()->getLibelle();
                        $nomResponsableSacem = $row[0]->getSacem()->getNomResponsable();
                        $prenomResponsableSacem = $row[0]->getSacem()->getPrenomResponsable();
                        $rueSacem = $row[0]->getSacem()->getCoordonnees()->getAdresse();
                        $codePostalSacem = $row[0]->getSacem()->getCoordonnees()->getCodePostal();
                        $villeSacem = $row[0]->getSacem()->getCoordonnees()->getVille();
                        $informationsComplementairesSacem = $row[0]->getSacem()->getCoordonnees()->getInformationsComplementaires();
                        $telephonePrincipalSacem = $row[0]->getSacem()->getCoordonnees()->getTelephonePrincipal();
                        $faxSacem = $row[0]->getSacem()->getCoordonnees()->getFax();
                        $emailSacem = $row[0]->getSacem()->getCoordonnees()->getEmail();
                    }

                    fputcsv($handle, $this->iso_converter(array(
                        $row[0]->getId(),
                        $row[0]->getEnseigne(),
                        $row[0]->getFormeJuridique()->getLibelle(),
                        $row[0]->getNomJuridique(),
                        $row[0]->getSiteInternet(),
                        $row[0]->getCodeSiret(),
                        $row[0]->getCodeAPE()->getCodeAPE(),
                        $row[0]->getNombreSalaries(),
                        $row[0]->getCapacite()->getLibelle(),
                        $row[0]->getCoordonnees()->getAdresse(),
                        $row[0]->getCoordonnees()->getCodePostal(),
                        $row[0]->getCoordonnees()->getVille(),
                        $row[0]->getCoordonnees()->getInformationsComplementaires(),
                        $row[0]->getCoordonnees()->getTelephonePrincipal(),
                        $row[0]->getCoordonnees()->getTelephoneSecondaire(),
                        $row[0]->getCoordonnees()->getFax(),
                        $row[0]->getCoordonnees()->getEmail(),
                        $row[0]->getCoordonnees()->getAutorisation()->getLibelle(),
                        $codeadherent,
                        $etatCotisation,
                        $civiliteResponsable,
                        $nomResponsable,
                        $prenomResponsable,
                        $rueResponsable,
                        $codePostalResponsable,
                        $villeResponsable,
                        $informationsComplementairesResponsable,
                        $telephonePrincipalResponsable,
                        $telephoneSecondaireResponsable,
                        $faxResponsable,
                        $emailResponsable,
                        $autorisationCoordonneesResponsable,
                        $libelleSacem,
                        $civiliteResponsableSacem,
                        $nomResponsableSacem,
                        $prenomResponsableSacem,
                        $rueSacem,
                        $codePostalSacem,
                        $villeSacem,
                        $informationsComplementairesSacem,
                        $telephonePrincipalSacem,
                        $faxSacem,
                        $emailSacem,
                        $loginSite,
                        $mdpSite,
                    )), ';');
                }

                $em->detach($row[0]);
            }

            fclose($handle);
        });
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }

    public function exportCoordonneesAppelCotisationAnneeEnCoursAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Etablissement')
                ->exportAllEtablissementsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Enseigne',
                'Nom Juridique',
                'Adresse Etablissement Rue',
                'Adresse Etablissement Code Postal',
                'Adresse Etablissement Ville',
                'Adresse Etablissement Informations Complémentaires',
                'Etablissement Email',
                'Civilité Responsable',
                'Nom Responsable',
                'Prénom Responsable'
            )), ';');

            while (false !== ($row = $results->next())) {

                $isEtatEtablissementFermeeDefinitivement = null;
                if ($row[0]->getEtatEtablissement() != null AND $row[0]->getEtatEtablissement()->getId() == 4)
                    $isEtatEtablissementFermeeDefinitivement = true;
                else
                    $isEtatEtablissementFermeeDefinitivement = false;

                $cotisationEnCoursOuFuture = null;
                $isAdherentAvecCotisationRecente = null;
                if ($row[0]->getAdherent() != null)
                {
                    $cotisationEnCoursOuFuture = $em->getRepository('SNDLLPlatformBundle:Cotisation')->getCotisationEnCoursOuFuture($row[0]->getAdherent()->getCodeAdherent());
                    $nbAnnees = 2;
                    $isAdherentAvecCotisationRecente = $em->getRepository('SNDLLPlatformBundle:Cotisation')->isCotisationRecente($row[0]->getAdherent()->getIdDerniereCotisation(), $nbAnnees);
                }

                $isEtablissementModifieRecemment = null;
                $nbAnnees = 1;
                $dateImport = new \DateTime("2015-03-05");
                $isEtablissementModifieRecemment = $em->getRepository('SNDLLPlatformBundle:Etablissement')->isEtablissementModifieRecemment($row[0]->getId(), $nbAnnees, $dateImport);

                if ($isEtatEtablissementFermeeDefinitivement == false AND $cotisationEnCoursOuFuture == null AND ($isAdherentAvecCotisationRecente == true OR $isEtablissementModifieRecemment == true))
                {
                    $civiliteResponsable = null;
                    $nomResponsable = null;
                    $prenomResponsable = null;

                    $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                        ->getResponsable($row[0]->getId());
                    if ($responsable != null)
                    {
                        if ($responsable->getCivilite() != null)
                        {
                            $civiliteResponsable = $responsable->getCivilite()->getLibelle();
                        }
                        $nomResponsable = $responsable->getNom();
                        $prenomResponsable = $responsable->getPrenom();
                    }

                    fputcsv($handle, $this->iso_converter(array(
                        $row[0]->getId(),
                        $row[0]->getEnseigne(),
                        $row[0]->getNomJuridique(),
                        $row[0]->getCoordonnees()->getAdresse(),
                        $row[0]->getCoordonnees()->getCodePostal(),
                        $row[0]->getCoordonnees()->getVille(),
                        $row[0]->getCoordonnees()->getInformationsComplementaires(),
                        $row[0]->getCoordonnees()->getEmail(),
                        $civiliteResponsable,
                        $nomResponsable,
                        $prenomResponsable,
                    )), ';');
                }

                $em->detach($row[0]);
            }

            fclose($handle);
        });
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }

    public function exportCoordonneesAppelCotisationAnneeProchaineAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Etablissement')
                ->exportAllEtablissementsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Enseigne',
                'Nom Juridique',
                'Adresse Etablissement Rue',
                'Adresse Etablissement Code Postal',
                'Adresse Etablissement Ville',
                'Adresse Etablissement Informations Complémentaires',
                'Etablissement Email',
                'Civilité Responsable',
                'Nom Responsable',
                'Prénom Responsable'
            )), ';');

            while (false !== ($row = $results->next())) {

                $isEtatEtablissementFermeeDefinitivement = null;
                if ($row[0]->getEtatEtablissement() != null AND $row[0]->getEtatEtablissement()->getId() == 4)
                    $isEtatEtablissementFermeeDefinitivement = true;
                else
                    $isEtatEtablissementFermeeDefinitivement = false;

                $cotisationAnneeProchaine = null;
                $isAdherentAvecCotisationRecente = null;
                if ($row[0]->getAdherent() != null)
                {
                    $cotisationAnneeProchaine = $em->getRepository('SNDLLPlatformBundle:Cotisation')->getCotisationAnneeProchaine($row[0]->getAdherent()->getCodeAdherent());
                    $nbAnnees = 1;
                    $isAdherentAvecCotisationRecente = $em->getRepository('SNDLLPlatformBundle:Cotisation')->isCotisationRecente($row[0]->getAdherent()->getIdDerniereCotisation(), $nbAnnees);
                }

                $isEtablissementModifieRecemment = null;
                $nbAnnees = 0;
                $dateImport = new \DateTime("2015-03-05");
                $isEtablissementModifieRecemment = $em->getRepository('SNDLLPlatformBundle:Etablissement')->isEtablissementModifieRecemment($row[0]->getId(), $nbAnnees, $dateImport);

                if ($isEtatEtablissementFermeeDefinitivement == false AND $cotisationAnneeProchaine == null AND ($isAdherentAvecCotisationRecente == true OR $isEtablissementModifieRecemment == true))
                {
                    $civiliteResponsable = null;
                    $nomResponsable = null;
                    $prenomResponsable = null;

                    $responsable = $em->getRepository('SNDLLPlatformBundle:Contact')
                        ->getResponsable($row[0]->getId());
                    if ($responsable != null)
                    {
                        if ($responsable->getCivilite() != null)
                        {
                            $civiliteResponsable = $responsable->getCivilite()->getLibelle();
                        }
                        $nomResponsable = $responsable->getNom();
                        $prenomResponsable = $responsable->getPrenom();
                    }

                    fputcsv($handle, $this->iso_converter(array(
                        $row[0]->getId(),
                        $row[0]->getEnseigne(),
                        $row[0]->getNomJuridique(),
                        $row[0]->getCoordonnees()->getAdresse(),
                        $row[0]->getCoordonnees()->getCodePostal(),
                        $row[0]->getCoordonnees()->getVille(),
                        $row[0]->getCoordonnees()->getInformationsComplementaires(),
                        $row[0]->getCoordonnees()->getEmail(),
                        $civiliteResponsable,
                        $nomResponsable,
                        $prenomResponsable,
                    )), ';');
                }

                $em->detach($row[0]);
            }

            fclose($handle);
        });
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }

    public function exportAllCotisationsAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Cotisation')
                ->exportAllCotisationsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Type Adhésion',
                'Date Début',
                'Date Fin',
                'Date Règlement',
                'Montant Cotisation',
                'Code Adhérent',
                'Mode Règlement'
            )), ';');

            while (false !== ($row = $results->next())) {
                fputcsv($handle, $this->iso_converter(array(
                    $row[0]->getId(),
                    $row[0]->getTypeAdhesion()->getLibelle(),
                    $row[0]->getDateDebut()->format('d/m/Y'),
                    $row[0]->getDateFin()->format('d/m/Y'),
                    $row[0]->getDateReglement()->format('d/m/Y'),
                    $row[0]->getPrixCotisationTTC(),
                    $row[0]->getAdherent()->getCodeAdherent(),
                    $row[0]->getModeReglement()->getLibelle()
                )), ';');
                $em->detach($row[0]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }

    public function exportCotisationsEnCoursAction()
    {
        $container = $this->container;
        $response = new StreamedResponse(function() use($container) {

            $em = $container->get('doctrine')->getManager();

            $results = $em->getRepository('SNDLLPlatformBundle:Cotisation')
                ->exportAllCotisationsQB()->iterate();
            $handle = fopen('php://output', 'r+');

            fputcsv($handle, $this->iso_converter(array(
                'Id',
                'Type Adhésion',
                'Date Début',
                'Date Fin',
                'Date Règlement',
                'Montant Cotisation',
                'Code Adhérent',
                'Mode Règlement'
            )), ';');

            while (false !== ($row = $results->next())) {
                $cotisationEnCours = $em->getRepository('SNDLLPlatformBundle:Cotisation')->isCotisationEnCours($row[0]->getId());
                if ($cotisationEnCours == True)
                {
                    fputcsv($handle, $this->iso_converter(array(
                        $row[0]->getId(),
                        $row[0]->getTypeAdhesion()->getLibelle(),
                        $row[0]->getDateDebut()->format('d/m/Y'),
                        $row[0]->getDateFin()->format('d/m/Y'),
                        $row[0]->getDateReglement()->format('d/m/Y'),
                        $row[0]->getPrixCotisationTTC(),
                        $row[0]->getAdherent()->getCodeAdherent(),
                        $row[0]->getModeReglement()->getLibelle()
                    )), ';');
                    $em->detach($row[0]);
                }
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;
    }


    public function iso_converter($array)
    {
        array_walk_recursive($array, function(&$row, $key){
            if(mb_detect_encoding($row, 'utf-8', true)){
                $row = utf8_decode($row);
            }
        });

        return $array;
    }
}
