<?php

class InterventionControleur
{
    private $intervention;

    public function __construct($bdd)
    {
        $this->intervention = new Intervention($bdd);
    }

    public function ajouterIntervention($desc, $statut, $idproduit, $idclient)
    {
        $this->intervention->ajouterIntervention($desc, $statut, $idproduit, $idclient);
    }

    public function getInterventionClient($idclient)
    {
        return $this->intervention->getInterventionClient($idclient);
    }

    public function getInterventionTermineeClient($idclient)
    {
        return $this->intervention->getInterventionTermineeClient($idclient);
    }

    public function getInterventionTechnicien($idtechnicien)
    {
        return $this->intervention->getInterventionTechnicien($idtechnicien);
    }

    public function getInterventionTermineeTechnicien($idtechnicien)
    {
        return $this->intervention->getInterventionTermineeTechnicien($idtechnicien);
    }

    public function getInterventionProduit($idproduit)
    {
       return  $this->intervention->getInterventionProduit($idproduit);
    }

    // Renvoie les interventions avec le statut donné en paramètre
    public function getInterventionStatut($statut)
    {
       return  $this->intervention->getInterventionStatut($statut);
    }

    public function updateInterventionStatut($idintervention, $statut)
    {
       return  $this->intervention->updateInterventionStatut($idintervention, $statut);
    }

    public function accepterIntervention($idintervention)
    {
       return  $this->intervention->accepterIntervention($idintervention);
    }

    public function getInterventionById($id)
    {
        return $this->intervention->getInterventionById($id);
    }

    public function supprimerIntervention($id)
    {
        return $this->intervention->supprimerIntervention($id);
    }

    public function accepterPanne($dateInter, $prixInter, $dureeInter, $idInter, $idtechnicien)
    {
        return $this->intervention->accepterPanne($dateInter, $prixInter, $dureeInter, $idInter, $idtechnicien);
    }

    public function viderTechData($idInter)
    {
        return $this->intervention->viderTechData($idInter);
    }

    public function getNbInterventionClient($id, $statut)
    {
        return $this->intervention->getNbInterventionClient($id, $statut);
    }

    public function getPrixInterventionUtilisateur($id, $statut)
    {
        return $this->intervention->getPrixInterventionUtilisateur($id, $statut);
    }

    public function getNbInterventionMoisUtilisateur($id, $statut, $month)
    {
        return $this->intervention->getNbInterventionMoisUtilisateur($id, $statut, $month);
    }





    public function getAllInterventions()
    {
        return $this->intervention->getAllInterventions();
    }


}

?>
