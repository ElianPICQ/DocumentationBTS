<?php

class ProduitControleur
{
    private $produit;

    public function __construct($bdd)
    {
        $this->produit = new Produit($bdd);
    }

    public function ajouterProduit($nom, $marque, $urlImage, $etat, $categorie, $idclient)
    {
        return $this->produit->ajouterProduit($nom, $marque, $urlImage, $etat, $categorie, $idclient);
    }

    public function getProduitById($id)
    {
        return $this->produit->getProduitById($id);
    }


    

    public function getAllProduits()
    {
        return $this->produit->getAllProduits();
    }

    public function updateProduit($nom, $marque, $dateAchat, $urlImage, $etat, $idCategorie, $idProduit)
    {
        return $this->produit->updateProduit($nom, $marque, $dateAchat, $urlImage, $etat, $idCategorie, $idProduit);
    }

    public function supprimerProduit($idProduit)
    {
        return $this->produit->supprimerProduit($idProduit);
    }


}

?>
