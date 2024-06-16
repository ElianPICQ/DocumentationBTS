<?php
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'connexion';

if ( ! isset($_SESSION['email']))
{
    require_once("vue/partage/head_no_header.php");

    switch($page)
    {
        case "connexion" :
            require_once("vue/partage/connexion.php");
            break;
        case "inscription" :
            require_once("vue/partage/inscription.php");
            break;
        default:
            require_once("vue/partage/connexion.php");
            break;
    }
    echo "</body></html>";
}


if (isset($_SESSION['email']))
{
    require_once("vue/partage/header.php");

    switch($page)
    {
        case "tableaudebord":
            require_once("vue/Client/tableaudebord.php");
            break;

        case "profil":
            require_once("vue/Client/profil.php");
            break;

        case "signalerunepanne":
            require_once("vue/Client/signalerunepanne.php");
            break;

        case "accepterunepanne":
            if ($_SESSION['role'] == "technicien")
                require_once("vue/technicien/accepterunepanne.php");
            break;

        case "detailinter":
            if ($_SESSION['role'] == "technicien")
                require_once("vue/technicien/detailinter.php");
            break;

        case "historique":
            require_once("vue/partage/historique.php");
            break;

        case "deconnecter":
            // Retirer email de la session
            unset($_SESSION['email']);

            // Détruire la session
            session_destroy();

            // Recharge la page index
            header("Location: index.php");
            break;

        default:
            require_once("vue/Client/tableaudebord.php");
            break;
    }

    require_once("vue/partage/footer.php");
}
?>