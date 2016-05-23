<?php

namespace SNDLL\PlatformBundle\Controller;

use SNDLL\PlatformBundle\Entity\Identifiants;
use SNDLL\PlatformBundle\Entity\IdentifiantsTemporaires;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SNDLL\PlatformBundle\Entity\Adherent;
use SNDLL\PlatformBundle\Entity\Cotisation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Constraints\DateTime;

class WordpressController extends Controller
{
    protected $dsn;

    protected $userName;

    protected $password;

    protected $entityManager;

    public function __construct($dsn, $userName, $password, $entityManager)
    {
        $this->dsn = $dsn;
        $this->userName = $userName;
        $this->password = $password;
        $this->entityManager = $entityManager;
    }


    public function majWordPress(Adherent $adherent, Request $request)
    {
        if (null === $adherent)
        {
            throw new \Exception("L'adhérent n'existe pas.");
        }

        try
        {
            $bdd = new \PDO($this->dsn, $this->userName, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $e)
        {
            throw new \Exception("Erreur de connexion à la base de données Wordpress.");
        }

        $this->majUserWordPress($adherent);

        $this->majPaidMembershipsPro($adherent);

        $request->getSession()->getFlashBag()->add('notice', 'Les informations ont bien été envoyées au site sndll.info.');
        return true;

    }

    public function deleteUserWordpress(Adherent $adherent, Request $request)
    {
        if (null === $adherent)
        {
            throw new \Exception("L'adhérent n'existe pas.");
        }

        try
        {
            $bdd = new \PDO($this->dsn, $this->userName, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $e)
        {
            throw new \Exception("Erreur de connexion à la base de données de Wordpress : ".$e->getMessage());
        }

        $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = ' . $adherent->getCodeAdherent());
        $utilisateurWP = $query->fetch();

        // $query = $bdd->query('DELETE FROM wp_pmpro_memberships_users WHERE user_id = ' . $utilisateurWP['ID']);

        // $query = $bdd->query('DELETE FROM wp_usermeta WHERE user_id = ' . $utilisateurWP['ID']);

        // $query = $bdd->query('DELETE FROM wp_users WHERE user_login = ' . $adherent->getCodeAdherent());

        $request->getSession()->getFlashBag()->add('notice', 'L\'établissement n\'a plus accès au site sndll.info.');

        return true;
    }

    public function majUserWordPress(Adherent $adherent)
    {
        if (null === $adherent)
        {
            throw new \Exception("L'adhérent n'existe pas.");
        }

        try
        {
            $bdd = new \PDO($this->dsn, $this->userName, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $e)
        {
            throw new \Exception("Erreur de connexion à la base de données de Wordpress : ".$e->getMessage());
        }

        $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = ' . $adherent->getCodeAdherent());
        $utilisateurWP = $query->fetch();

        if ($utilisateurWP == null)
        {
            $codeAdherent = $adherent->getCodeAdherent();
            $userPasswordClair = $this->generationPassword();
            $userPasswordCrypte = $this->cryptePassword($userPasswordClair);
            $userEmail = utf8_decode($adherent->getEtablissement()->getCoordonnees()->getEmail());
            $enseigne = htmlspecialchars(utf8_decode($adherent->getEtablissement()->getEnseigne()));

            $query = $bdd->query('INSERT INTO wp_users(user_login, user_pass, user_nicename, user_email, user_registered, display_name) VALUE ("' . $codeAdherent . '", "' . $userPasswordCrypte . '", "' . $codeAdherent . '", "' . $userEmail . '", CURRENT_TIMESTAMP, "' . $enseigne . '")');

            $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = ' . $adherent->getCodeAdherent());
            $utilisateurWP = $query->fetch();
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "nickname", "' . $codeAdherent . '")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "first_name", "")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "last_name", "")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "description", "")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "rich_editing", "true")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "comment_shortcuts", "false")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "admin_color", "fresh")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "use_ssl", "0")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "show_admin_bar_front", "true")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "wp_user_level", "0")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurWP['ID'] . ', "show_welcome_panel", "0")');

            $identifiant = new Identifiants();

            $identifiant->setLoginWP($codeAdherent);
            $identifiant->setPasswordWP($userPasswordClair);
            $identifiant->setDateDerniereModification(new \DateTime());

            $this->entityManager->persist($identifiant);

            $adherent->setIdentifiants($identifiant);

            $this->entityManager->flush();
        }else{
            $userPasswordClair = $adherent->getIdentifiants()->getPasswordWP();
            $userPasswordCrypte = $this->cryptePassword($userPasswordClair);
            $userEmail = utf8_decode($adherent->getEtablissement()->getCoordonnees()->getEmail());
            $enseigne = htmlspecialchars(utf8_decode($adherent->getEtablissement()->getEnseigne()));

            $query = $bdd->query('UPDATE wp_users SET user_pass = "' . $userPasswordCrypte . '", user_email = "' . $userEmail . '", display_name = "' .$enseigne . '" WHERE wp_users.ID = ' . $utilisateurWP['ID']);
        }

        return true;
    }

    public function majPaidMembershipsPro(Adherent $adherent)
    {
        if (null === $adherent)
        {
            throw new \Exception("L'adhérent n'existe pas.");
        }

        try
        {
            $bdd = new \PDO($this->dsn, $this->userName, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $e)
        {
            throw new \Exception("Erreur de connexion à la base de données de Wordpress : ".$e->getMessage());
        }

        $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = ' . $adherent->getCodeAdherent());
        $utilisateurWP = $query->fetch();

        if ($utilisateurWP == null)
        {
            throw new \Exception("Utilisateur inexistant dans la base de données Wordpress.");
        }

        $query = $bdd->query('DELETE FROM wp_pmpro_memberships_users WHERE user_id = ' . $utilisateurWP['ID']);

        $cotisations = $this->entityManager->getRepository('SNDLLPlatformBundle:Cotisation')
            ->getCotisationsByAdherent($adherent);

        foreach ($cotisations as $cotisation)
        {
            $userIDWP = $utilisateurWP['ID'];

            $dateDebut = new \DateTime();
            $dateDebutTimestamp = $cotisation->getDateDebut()->getTimestamp();
            $dateDebut = date_format($cotisation->getDateDebut(), "Y-m-d H:i:s");

            $dateFin = new \DateTime();
            $dateFinTimestamp = $cotisation->getDateFin()->getTimestamp();
            $dateFin = date_format($cotisation->getDateFin(), "Y-m-d H:i:s");

            $dateCourante = new \DateTime();
            $dateCouranteTimestamp = $dateCourante->getTimestamp();

            $prixCotisation = $cotisation->getPrixCotisationTTC();

            if ($dateCouranteTimestamp <= $dateFinTimestamp)
            {
                $status = "active";
            }else{
                $status = "inactive";
            }

            $query = $bdd->query('INSERT INTO wp_pmpro_memberships_users(user_id, membership_id, initial_payment, billing_amount, cycle_period, status, startdate, enddate, modified) VALUE (' . $userIDWP . ', 1, ' . $prixCotisation . ', ' . $prixCotisation . ', "", "' . $status . '", "' . $dateDebut .'", "' . $dateFin . '", CURRENT_TIMESTAMP)');
        }
    }

    public function renewPasswordWordpress(Adherent $adherent, Request $request)
    {
        $password = $this->generationPassword();
        $adherent->getIdentifiants()->setPasswordWP($password);
        $this->entityManager->flush();
        $this->majWordPress($adherent, $request);

        $request->getSession()->getFlashBag()->add('notice', 'Le mot de passe a bien été regénéré.');
        return true;
    }

    public function generationPassword()
    {
        $password = "";

        $chaine = "abcdefghijklmnopqrstuvwxyz";
        $longeurChaine = strlen($chaine);

        for($i = 1; $i <= 9; $i++)
        {
            $placeAleatoire = mt_rand(0,($longeurChaine-1));
            $password .= $chaine[$placeAleatoire];
        }

        return $password;
    }

    public function generationLoginTemp()
    {
        $password = "temp";

        $chaine = "abcdefghijklmnopqrstuvwxyz";
        $longeurChaine = strlen($chaine);

        for($i = 1; $i <= 5; $i++)
        {
            $placeAleatoire = mt_rand(0,($longeurChaine-1));
            $password .= $chaine[$placeAleatoire];
        }

        return $password;
    }

    public function cryptePassword($password)
    {
        return MD5($password);
    }

    public function genTempJourWordpress(Request $request)
    {
        $dateActuelle = new \DateTime();
        $dateDeFin = new \DateTime();
        $dateDeFin = $dateDeFin->add(new \DateInterval('P1D'));
        $identifiantTemporaire = new IdentifiantsTemporaires();
        $identifiantTemporaire->setLoginWP($this->generationLoginTemp());
        $identifiantTemporaire->setPasswordWP($this->generationPassword());
        $identifiantTemporaire->setDateCreation($dateActuelle);
        $identifiantTemporaire->setDateDebut($dateActuelle);
        $identifiantTemporaire->setDateFin($dateDeFin);
        $this->entityManager->persist($identifiantTemporaire);
        $this->entityManager->flush();
        $this->genIdentifiantTempWordPress($identifiantTemporaire);
        $request->getSession()->getFlashBag()->add('notice', 'L\'identifiant a bien été rajouté et est valable 24h.');

        return true;
    }

    public function genTempSemaineWordpress(Request $request)
    {
        $dateActuelle = new \DateTime();
        $dateDeFin = new \DateTime();
        $dateDeFin = $dateDeFin->add(new \DateInterval('P7D'));
        $identifiantTemporaire = new IdentifiantsTemporaires();
        $identifiantTemporaire->setLoginWP($this->generationLoginTemp());
        $identifiantTemporaire->setPasswordWP($this->generationPassword());
        $identifiantTemporaire->setDateCreation($dateActuelle);
        $identifiantTemporaire->setDateDebut($dateActuelle);
        $identifiantTemporaire->setDateFin($dateDeFin);
        $this->entityManager->persist($identifiantTemporaire);
        $this->entityManager->flush();
        $this->genIdentifiantTempWordPress($identifiantTemporaire);
        $request->getSession()->getFlashBag()->add('notice', 'L\'identifiant a bien été rajouté et est valable une semaine.');

        return true;
    }

    public function genIdentifiantTempWordPress($identifiantTemporaire)
    {
        try
        {
            $bdd = new \PDO($this->dsn, $this->userName, $this->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
        catch(\Exception $e)
        {
            throw new \Exception("Erreur de connexion à la base de données de Wordpress : ".$e->getMessage());
        }

        $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = "' . $identifiantTemporaire->getLoginWP() . '"');
        $utilisateurTempWP = $query->fetch();

        if ($utilisateurTempWP == null)
        {
            $codeAdherent = $identifiantTemporaire->getLoginWP();
            $userPasswordClair = $identifiantTemporaire->getPasswordWP();
            $userPasswordCrypte = $this->cryptePassword($userPasswordClair);
            $userEmail = utf8_decode("service-info@sndll.org");
            $enseigne = htmlspecialchars(utf8_decode("Invité"));

            $query = $bdd->query('INSERT INTO wp_users(user_login, user_pass, user_nicename, user_email, user_registered, display_name) VALUE ("' . $codeAdherent . '", "' . $userPasswordCrypte . '", "' . $codeAdherent . '", "' . $userEmail . '", CURRENT_TIMESTAMP, "' . $enseigne . '")');

            $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = "' . $identifiantTemporaire->getLoginWP() . '"');
            $utilisateurTempWP = $query->fetch();
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "nickname", "' . $codeAdherent . '")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "first_name", "")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "last_name", "")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "description", "")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "rich_editing", "true")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "comment_shortcuts", "false")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "admin_color", "fresh")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "use_ssl", "0")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "show_admin_bar_front", "true")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "wp_user_level", "0")');
            $query = $bdd->query('INSERT INTO wp_usermeta(user_id, meta_key, meta_value) VALUE (' . $utilisateurTempWP['ID'] . ', "show_welcome_panel", "0")');
        }

        $query = $bdd->query('SELECT * FROM wp_users WHERE user_login = "' . $identifiantTemporaire->getLoginWP() . '"');
        $utilisateurWP = $query->fetch();

        if ($utilisateurTempWP == null)
        {
            throw new \Exception("Utilisateur inexistant dans la base de données Wordpress.");
        }

        $query = $bdd->query('DELETE FROM wp_pmpro_memberships_users WHERE user_id = ' . $utilisateurTempWP['ID']);

        $userIDWP = $utilisateurWP['ID'];

        $dateDebut = $identifiantTemporaire->getDateDebut();
        $dateDebutTimestamp = $identifiantTemporaire->getDateDebut()->getTimestamp();
        $dateDebut = date_format($identifiantTemporaire->getDateDebut(), "Y-m-d H:i:s");

        $dateFin = $identifiantTemporaire->getDateFin();
        $dateFinTimestamp = $identifiantTemporaire->getDateFin()->getTimestamp();
        $dateFin = date_format($identifiantTemporaire->getDateFin(), "Y-m-d H:i:s");

        $dateCourante = new \DateTime();
        $dateCouranteTimestamp = $dateCourante->getTimestamp();

        $prixCotisation = "0";

        if ($dateCouranteTimestamp <= $dateFinTimestamp)
        {
            $status = "active";
        }else{
            $status = "inactive";
        }

        $query = $bdd->query('INSERT INTO wp_pmpro_memberships_users(user_id, membership_id, initial_payment, billing_amount, cycle_period, status, startdate, enddate, modified) VALUE (' . $userIDWP . ', 1, ' . $prixCotisation . ', ' . $prixCotisation . ', "", "' . $status . '", "' . $dateDebut .'", "' . $dateFin . '", CURRENT_TIMESTAMP)');

        return true;
    }
}
