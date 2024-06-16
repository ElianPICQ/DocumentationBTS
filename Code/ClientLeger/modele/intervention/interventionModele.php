<?php

class Intervention
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterIntervention($description, $statut, $idproduit, $idclient)
    {
        date_default_timezone_set("Europe/Paris");
        $currDate = date('Y-m-d H:i:s');

        $requete = "INSERT INTO intervention (date_creation_intervention, description, statut, idproduit, idclient) VALUES (:currDate, :description, :statut, :idproduit, :idclient);";

        $insert = $this->bdd->prepare($requete);

        $insert->bindParam(':currDate', $currDate, PDO::PARAM_STR);
        $insert->bindParam(':description', $description, PDO::PARAM_STR);
        $insert->bindParam(':statut', $statut, PDO::PARAM_STR);
        $insert->bindParam(':idproduit', $idproduit, PDO::PARAM_INT);
        $insert->bindParam(':idclient', $idclient, PDO::PARAM_INT);

        return $insert->execute();
    }

    public function getInterventionClient($idclient)
    {
        $requete = 'SELECT * FROM intervention i WHERE i.idclient = :idclient AND (statut = "en attente" OR statut = "acceptee" OR statut = "en cours")';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':idclient', $idclient, PDO::PARAM_INT);

        $select->execute();
        return $select->fetchAll();
    }

    public function getInterventionTermineeClient($idclient)
    {
        $requete = 'SELECT * FROM intervention i WHERE i.idclient = :idclient AND statut = "terminee";';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':idclient', $idclient, PDO::PARAM_INT);

        $select->execute();
        return $select->fetchAll();
    }

    public function getInterventionTechnicien($idtechnicien)
    {
        $requete = 'SELECT * FROM intervention i WHERE i.idtechnicien = :idtechnicien AND (statut = "acceptee" OR statut = "en cours" OR statut = "refusee")';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':idtechnicien', $idtechnicien, PDO::PARAM_INT);

        $select->execute();
        return $select->fetchAll();
    }

    public function getInterventionTermineeTechnicien($idtechnicien)
    {
        $requete = 'SELECT * FROM intervention i WHERE i.idtechnicien = :idtechnicien AND statut = "terminee";';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':idtechnicien', $idtechnicien, PDO::PARAM_INT);

        $select->execute();
        return $select->fetchAll();
    }

    public function getInterventionProduit($idproduit)
    {
        $requete = 'SELECT * FROM intervention i, produit p WHERE i.idproduit = p.:idproduit';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':idproduit', $idproduit, PDO::PARAM_INT);

        $select->execute();
        return $select->fetch();
    }

    // Retourne toutes les interventions avec le statut passé en paramètre
    public function getInterventionStatut($statut)
    {
        $requete = "SELECT * FROM intervention WHERE statut = :statut;";

        $select = $this->bdd->prepare($requete);
        $select->bindParam(":statut", $statut, PDO::PARAM_STR);

        $select->execute();
        return $select->fetchAll();
    }

    public function supprimerIntervention($id)
    {
        $requete = "DELETE FROM intervention WHERE idintervention = :id;";

        $delete = $this->bdd->prepare($requete);
        $delete->bindParam(":id", $id, PDO::PARAM_INT);

        return $delete->execute();
    }

    public function updateInterventionStatut($idintervention, $statut)
    {
        $requete = "UPDATE intervention SET statut = :statut WHERE idintervention = :idintervention;";

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":statut", $statut, PDO::PARAM_STR);
        $update->bindParam(":idintervention", $idintervention, PDO::PARAM_STR);

        return $update->execute();
    }

    public function accepterIntervention($idintervention)
    {
        $requete = "UPDATE intervention SET statut = 'en cours' WHERE idintervention = :idintervention;";

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":idintervention", $idintervention, PDO::PARAM_STR);

        return $update->execute();
    }

    public function accepterPanne($dateInter, $prixInter, $dureeInter, $idInter, $idtechnicien)
    {
        date_default_timezone_set("Europe/Paris");
        $currDate = date('Y-m-d H:i:s');

        $requete = 'UPDATE intervention SET date_intervention_acceptee = :currDate, date_intervention = :dateInter, prix_intervention = :prixInter, duree = :dureeInter, statut = "acceptee", idtechnicien = :idtechnicien WHERE idintervention = :idInter;';

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":currDate", $currDate);
        $update->bindParam(":dateInter", $dateInter);
        $update->bindParam(":prixInter", $prixInter, PDO::PARAM_INT);
        $update->bindParam(":dureeInter", $dureeInter, PDO::PARAM_INT);
        $update->bindParam(":idtechnicien", $idtechnicien, PDO::PARAM_INT);
        $update->bindParam(":idInter", $idInter, PDO::PARAM_INT);

        return $update->execute();
    }

    public function viderTechData($idInter)
    {
        $requete = 'UPDATE intervention SET date_intervention_acceptee = "0000-00-00", date_intervention = "0000-00-00", prix_intervention = 0, duree = 0, idtechnicien = 0 WHERE idintervention = :idInter;';

        $update = $this->bdd->prepare($requete);
        $update->bindParam(":idInter", $idInter, PDO::PARAM_INT);

        return $update->execute();
    }

    public function getNbInterventionClient($id, $statut)
    {
        $requete = 'SELECT COUNT(idintervention) FROM intervention WHERE idclient = :id AND statut = :statut;';

        $count = $this->bdd->prepare($requete);
        $count->bindParam(":id", $id, PDO::PARAM_INT);
        $count->bindParam(":statut", $statut, PDO::PARAM_STR);

        $count->execute();

        return $count->fetch();
    }

    public function getPrixInterventionUtilisateur($id, $statut)
    {
        $requete = 'SELECT SUM(prix_intervention) FROM intervention WHERE idclient = :id AND statut = :statut;';

        $count = $this->bdd->prepare($requete);
        $count->bindParam(":id", $id, PDO::PARAM_INT);
        $count->bindParam(":statut", $statut, PDO::PARAM_STR);

        $count->execute();

        return $count->fetch();
    }

    public function getNbInterventionMoisUtilisateur($id, $statut, $month)
    {
        $requete = 'SELECT COUNT(*) FROM intervention WHERE month(date_creation_intervention) = :month AND idclient = :id AND statut = :statut;';

        $count = $this->bdd->prepare($requete);
        $count->bindParam(":id", $id, PDO::PARAM_INT);
        $count->bindParam(":month", $month, PDO::PARAM_INT);
        $count->bindParam(":statut", $statut, PDO::PARAM_STR);

        $count->execute();

        return $count->fetch();
    }





    public function getAllInterventions()
    {
        $req = $this->bdd->prepare("SELECT * FROM intervention");
        $req->execute();
        return $req->fetchAll();
    }

    public function getInterventionById($id)
    {
        $requete = 'SELECT * FROM intervention WHERE idintervention = :id';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();
        return $select->fetch();
    }


}

?>
