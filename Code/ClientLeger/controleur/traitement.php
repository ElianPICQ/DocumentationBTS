<?php
session_start();

include('../bdd/bdd.php');

// Include Utilisateur Controleur & Modele
include('utilisateur/utilisateurControleur.php');
include('../modele/utilisateur/utilisateurModele.php');

// Include Produit Controleur & Modele
include('produit/produitControleur.php');
include('../modele/produit/produitModele.php');

// Include Intervention Controleur & Modele
include('intervention/interventionControleur.php');
include('../modele/intervention/interventionModele.php');


if (isset($_POST['action']))
{
    $utilisateurControleur = new UtilisateurControleur($bdd);
    $produitControleur = new ProduitControleur($bdd);
    $interventionControleur = new InterventionControleur($bdd);

    switch ($_POST['action'])
    {
        case 'inscrire':
            if ($utilisateurControleur->ajouterUtilisateur($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['tel'], $_POST['mdp'], $_POST['mdp2'], "client") == false)
            {
                echo "Impossible de créer l'utilisateur" . "<br />";
                header('Location: ../index.php?page=inscription');
                break;
            }
            $utilisateurControleur->ajouterClient($_POST['email'], $_POST['code_postal'], $_POST['date_naissance']);
            $unUtilisateur = $utilisateurControleur->connexion($_POST['email'], $_POST['mdp']);

            echo $unUtilisateur['idutilisateur'];
            echo $unUtilisateur['nom'];
            echo $unUtilisateur['prenom'];
            echo $unUtilisateur['email'];
            echo $unUtilisateur['tel'];
            echo $unUtilisateur['role'];
            echo $unUtilisateur['age'];

            $_SESSION['idutilisateur'] = $unUtilisateur['idutilisateur'];
            $_SESSION['nom'] = $unUtilisateur['nom'];
            $_SESSION['prenom'] = $unUtilisateur['prenom'];
            $_SESSION['email'] = $unUtilisateur['email'];
            $_SESSION['tel'] = $unUtilisateur['tel'];
            $_SESSION['role'] = $unUtilisateur['role'];
            $_SESSION['age'] = $unUtilisateur['age'];
            $_SESSION['code_postal'] = $unUtilisateur['code_postal'];
            header('Location: ../index.php?page=tableaudebord');
            break;


        case 'connecter':
            $unUtilisateur = $utilisateurControleur->connexion($_POST['email'], $_POST['mdp']);
            if ($unUtilisateur == NULL)
            {
                header('Location: ../index.php?page=connexion');
                break;
            }
            $_SESSION['idutilisateur'] = $unUtilisateur['idutilisateur'];
            $_SESSION['nom'] = $unUtilisateur['nom'];
            $_SESSION['prenom'] = $unUtilisateur['prenom'];
            $_SESSION['email'] = $unUtilisateur['email'];
            $_SESSION['tel'] = $unUtilisateur['tel'];
            $_SESSION['role'] = $unUtilisateur['role'];

            if ($unUtilisateur['role'] == "client")
            {
                $_SESSION['age'] = $unUtilisateur['age'];
                $_SESSION['code_postal'] = $unUtilisateur['code_postal'];
            }
            else if ($unUtilisateur['role'] == "technicien")
            {
                $_SESSION['competence'] = $unUtilisateur['competence'];
                $_SESSION['date_embauche'] = $unUtilisateur['date_embauche'];               
            }
            header('Location: ../index.php?page=tableaudebord');
            break;


        case 'signalerPanne':
            $nom = $_POST["produit"];
            $marque = $_POST["marque"];
            $urlImage = $_POST["image"];
            $categorie = $_POST["categorie"];
            $etat = $_POST["etat"];
            $desc = $_POST["description"];

            $idproduit = $produitControleur->ajouterProduit($nom, $marque, $urlImage, $etat, $categorie, $_SESSION['idutilisateur']);

            $interventionControleur->ajouterIntervention($desc, "en attente", $idproduit, $_SESSION['idutilisateur']);
            header('Location: ../index.php?page=tableaudebord');

            break;


        case 'changemdp':
            $currmdp = $_POST['currmdp'];
            $newmdp = $_POST['newmdp'];
            $newmdp2 = $_POST['newmdp2'];

            // Check si le mdp est bon
            if (! $utilisateurControleur->connexion($_SESSION['email'], $currmdp))
            {
                header('Location: ../index.php?page=profil');
                break;
            }
            
            // Check si les 2 nouveaux mdp sont identiques
            if (strcmp($newmdp, $newmdp2) != 0)
            {
                header('Location: ../index.php?page=profil');
                break;
            }

            // Update le mdp
            $utilisateurControleur->updatemdp($_SESSION['idutilisateur'], $newmdp);
            header('Location: ../index.php?page=profil');

            break;


        case 'changetel':
            $currmdp = $_POST['currmdp'];
            $newtel = $_POST['newtel'];

            // Check si le mdp est bon
            if (! $utilisateurControleur->connexion($_SESSION['email'], $currmdp))
            {
                header('Location: ../index.php?page=profil');
                break;
            }

            // Update le tel
            $utilisateurControleur->updatetel($_SESSION['idutilisateur'], $newtel);
            header('Location: ../index.php?page=profil');

            break;


        case 'changercodepostal':
            $currmdp = $_POST['currmdp'];
            $newcodepostal = $_POST['newcodepostal'];
            // Check si le mdp est bon
            if (! $utilisateurControleur->connexion($_SESSION['email'], $currmdp))
            {
                header('Location: ../index.php?page=profil');
                break;
            }

            // Update l'adresse
            $utilisateurControleur->updatecodepostal($_SESSION['idutilisateur'], $newcodepostal);
            header('Location: ../index.php?page=profil');

            break;


        case 'changecompetence':
            $currmdp = $_POST['currmdp'];
            $newcompetence = $_POST['newcompetence'];
            // Check si le mdp est bon
            if (! $utilisateurControleur->connexion($_SESSION['email'], $currmdp))
            {
                header('Location: ../index.php?page=profil');
                break;
            }

            // Update l'adresse
            $utilisateurControleur->updatecompetence($_SESSION['idutilisateur'], $newcompetence);
            header('Location: ../index.php?page=profil');

            break;


        case 'accepterPanne':
            $dateInter = $_POST['dateinter'];
            $prixInter = $_POST['prixinter'];
            $dureeInter = $_POST['dureeinter'];
            $idInter = $_POST['idinter'];

            $interventionControleur->accepterPanne($dateInter, $prixInter, $dureeInter, $idInter, $_SESSION['idutilisateur']);
            header('Location: ../index.php?page=accepterunepanne');

            break;

        case 'annulerInter':
            $idintervention = $_POST['idintervention'];
            $interventionControleur->updateInterventionStatut($idintervention, "en attente");
            $interventionControleur->viderTechData($idintervention);
            header('Location: ../index.php?page=tableaudebord');

            break;

        case 'terminerInter':
            $idintervention = $_POST['idintervention'];
            $interventionControleur->updateInterventionStatut($idintervention, "terminee");
            header('Location: ../index.php?page=tableaudebord');

            break;

        case 'supprimerInter':
            $idintervention = $_POST['idintervention'];
            $interventionControleur->supprimerIntervention($idintervention, "annulee");
            header('Location: ../index.php?page=tableaudebord');

            break;

        case 'rejeterInter':
            $idintervention = $_POST['idintervention'];
            $interventionControleur->updateInterventionStatut($idintervention, "refusee");
            header('Location: ../index.php?page=tableaudebord');

            break;

        case 'confirmerInter':
            $idintervention = $_POST['idintervention'];
            $interventionControleur->accepterIntervention($idintervention);
            header('Location: ../index.php?page=tableaudebord');

            break;


        default:
            header('Location: ../index.php?page=connexion');
            break;
    }
}


?>