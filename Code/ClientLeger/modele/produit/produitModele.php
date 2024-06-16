<?php

class Produit
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterProduit($nom, $marque, $urlImage, $etat, $categorie, $idclient)
    {
        $requete = "INSERT INTO Produit (nom_produit, marque, url_image, etat, categorie, idclient) VALUES (:nom, :marque, :urlImage, :etat, :categorie, :idclient);";

        $insert = $this->bdd->prepare($requete);

        $insert->bindParam(':nom', $nom, PDO::PARAM_STR);
        $insert->bindParam(':marque', $marque, PDO::PARAM_STR);
        $insert->bindParam(':urlImage', $urlImage, PDO::PARAM_STR);
        $insert->bindParam(':etat', $etat, PDO::PARAM_STR);
        $insert->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $insert->bindParam(':idclient', $idclient, PDO::PARAM_INT);

        $insert->execute();

        return $this->bdd->lastInsertId();
    }

    public function getProduitById($id)
    {
        $requete = 'SELECT * FROM Produit WHERE idproduit = :id';
        
        $select = $this->bdd->prepare($requete);
        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();
        return $select->fetch();
    }

    public function getAllProduits()
    {
        $req = $this->bdd->prepare("SELECT * FROM Produit");
        $req->execute();
        return $req->fetchAll();
    }

    public function updateProduit($nom, $marque, $dateAchat, $urlImage, $etat, $idCategorie, $idProduit)
    {
        $stmt = "UPDATE Produit SET nom_produit = :nom, marque = :marque, date_achat = :dateAchat, url_image = :urlImage, etat = :etat, idcategorie = :idCategorie WHERE idproduit = :idProduit";
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':dateAchat', $dateAchat);
        $stmt->bindParam(':urlImage', $urlImage);
        $stmt->bindParam(':etat', $etat);
        $stmt->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
        $stmt->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function supprimerProduit($idProduit)
    {
        $req = $this->bdd->prepare("DELETE FROM Produit WHERE idproduit = ?");
        return $req->execute([$idProduit]);
    }


}

?>
