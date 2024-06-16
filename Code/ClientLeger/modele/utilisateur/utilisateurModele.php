<?php

class Utilisateur
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterUtilisateur($nom, $prenom, $email, $tel, $mot_de_passe, $role)
    {
        $requete = "INSERT INTO Utilisateur (nom, prenom, email, tel, mot_de_passe, role) VALUES (:nom, :prenom, :email, :tel, :mot_de_passe, :role);";

        $insert = $this->bdd->prepare($requete);

        $insert->bindParam(':nom', $nom, PDO::PARAM_STR);
        $insert->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $insert->bindParam(':email', $email, PDO::PARAM_STR);
        $insert->bindParam(':tel', $tel, PDO::PARAM_STR);
        $insert->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $insert->bindParam(':role', $role, PDO::PARAM_STR);

        return $insert->execute();
    }

    public function ajouterClient($idclient, $code_postal, $date_naissance)
    {
        $requete = "INSERT INTO Client (idclient, code_postal, date_naissance) VALUES (:idclient, :code_postal, :date_naissance);";

        $insert = $this->bdd->prepare($requete);

        $insert->bindParam(':idclient', $idclient, PDO::PARAM_INT);
        $insert->bindParam(':code_postal', $code_postal, PDO::PARAM_STR);
        $insert->bindParam(':date_naissance', $date_naissance);

        return $insert->execute();
    }

    public function connexion($email, $mdp)
    {
        $requete = "SELECT * FROM Utilisateur WHERE email = :email && mot_de_passe = :mdp;";

        $select = $this->bdd->prepare($requete);

        $select->bindParam(':email', $email, PDO::PARAM_STR);
        $select->bindParam(':mdp', $mdp, PDO::PARAM_STR);

        $select->execute();

        return $select->fetch();
    }

    public function getUtilisateur($email)
    {
        $requete = "SELECT idutilisateur FROM Utilisateur WHERE email = :email;";

        $select = $this->bdd->prepare($requete);
        $select->bindParam(':email', $email, PDO::PARAM_STR);
        $select->execute();

        return $select->fetch();
    }

    public function getUtilisateurById($id)
    {
        $requete = 'SELECT * FROM Utilisateur WHERE idutilisateur = :id';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();
        return $select->fetch();
    }

    public function getClientById($id)
    {
        $requete = 'SELECT * FROM lesClients WHERE idclient = :id';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();
        return $select->fetch();
    }

    public function getTechnicienById($id)
    {
        $requete = 'SELECT * FROM lesTechniciens WHERE idtechnicien = :id';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();
        return $select->fetch();
    }

    public function updatemdp($idutilisateur, $newmdp)
    {
        $requete = 'UPDATE Utilisateur SET mot_de_passe = :newmdp WHERE idutilisateur = :idutilisateur;';

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":newmdp", $newmdp, PDO::PARAM_STR);
        $update->bindParam(":idutilisateur", $idutilisateur, PDO::PARAM_INT);

        return $update->execute();
    }

    public function updatetel($idutilisateur, $newtel)
    {
        $requete = 'UPDATE Utilisateur SET tel = :newtel WHERE idutilisateur = :idutilisateur;';

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":newtel", $newtel, PDO::PARAM_STR);
        $update->bindParam(":idutilisateur", $idutilisateur, PDO::PARAM_INT);

        return $update->execute();
    }

    public function updatecodepostal($idclient, $newcodepostal)
    {
        $requete = 'UPDATE Client SET code_postal = :newcodepostal WHERE idclient = :idclient;';

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":newcodepostal", $newcodepostal, PDO::PARAM_STR);
        $update->bindParam(":idclient", $idclient, PDO::PARAM_INT);

        return $update->execute();
    }

    public function updatecompetence($idtechnicien, $newcomptence)
    {
        echo "JE SUIS DANS LE MODELE!";
        $requete = 'UPDATE Technicien SET competence = :newcomptence WHERE idtechnicien = :idtechnicien;';

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":newcomptence", $newcomptence, PDO::PARAM_STR);
        $update->bindParam(":idtechnicien", $idtechnicien, PDO::PARAM_INT);

        return $update->execute();
    }


    public function getGrainSel (){
        $requete = $this->bdd->prepare("SELECT nb FROM grainSel;");
        $requete->execute (); 
        return  $requete->fetch ();
    }
}

?>
