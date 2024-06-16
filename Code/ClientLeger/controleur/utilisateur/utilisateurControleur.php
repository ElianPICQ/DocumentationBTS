<?php

class UtilisateurControleur {
    private $utilisateur;

    public function __construct($bdd) {
        $this->utilisateur = new Utilisateur($bdd);
    }

    public function ajouterUtilisateur($nom, $prenom, $email, $tel, $mdp, $mdp2, $role)
    {
        // Check si un compte avec la meme email existe
        if ($this->utilisateur->getUtilisateur($email))
        {
            // On ne voit pas le echo vu qu'on recharge la page juste apres
            echo "Un compte avec cette adresse mail existte déjà" . "<br />";
            return false;
        }
        // Check si les 2 mdp sont identiques
        if (strcmp($mdp, $mdp2) != 0)
        {
            echo "Les mots de passe sont différents" . "<br />";
            return false;
        }

        return $this->utilisateur->ajouterUtilisateur($nom, $prenom, $email, $tel, $mdp, $role);
    }

    public function ajouterClient($email, $code_postal, $date)
    {
        $utilisateur = $this->utilisateur->getUtilisateur($email);
        $date_naissance = date("Y-m-d", strtotime($date));

        return $this->utilisateur->ajouterClient($utilisateur['idutilisateur'], $code_postal, $date_naissance);
    }

    public function connexion($email, $mdp)
    {
        $gsel = $this->utilisateur->getGrainSel();
        $hashmdp = md5($mdp . $gsel['nb']);

        $unUtilisateur = $this->utilisateur->connexion($email, $hashmdp);
        return $unUtilisateur;
    }

    public function getUtilisateurById($id)
    {
        return $this->utilisateur->getUtilisateurById($id);
    }

    public function getClientById($id)
    {
        return $this->utilisateur->getClientById($id);
    }

    public function getTechnicienById($id)
    {
        return $this->utilisateur->getTechnicienById($id);
    }

    public function updatemdp($idutilisateur, $newmdp)
    {
        $gsel = $this->utilisateur->getGrainSel();
        $hashmdp = md5($newmdp . $gsel['nb']);

        $this->utilisateur->updatemdp($idutilisateur, $hashmdp);
    }

    public function updatetel($idutilisateur, $newtel)
    {

        $this->utilisateur->updatetel($idutilisateur, $newtel);
    }

    public function updatecodepostal($idclient, $newcodepostal)
    {
        $this->utilisateur->updatecodepostal($idclient, $newcodepostal);
    }
    
    public function updatecompetence($idtechnicien, $newcomptence)
    {
        $this->utilisateur->updatecompetence($idtechnicien, $newcomptence);
    }

}
?>