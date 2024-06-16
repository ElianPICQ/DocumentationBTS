<?php

include('bdd/bdd.php');

// Include Utilisateur Controleur & Modele
include('controleur/utilisateur/utilisateurControleur.php');
include('modele/utilisateur/utilisateurModele.php');

// Include Produit Controleur & Modele
include('controleur/produit/produitControleur.php');
include('modele/produit/produitModele.php');

// Include Intervention Controleur & Modele
include('controleur/intervention/interventionControleur.php');
include('modele/intervention/interventionModele.php');

$interventionControleur = new InterventionControleur($bdd);
$produitControleur = new ProduitControleur($bdd);
$utilisateurControleur = new UtilisateurControleur($bdd);

$idInter = $_GET["idinter"];
$intervention = $interventionControleur->getInterventionById($idInter);
$client = $utilisateurControleur->getClientById($intervention['idclient']);
$produit = $produitControleur->getProduitById($intervention['idproduit']);

?>

<main id="detail-inter">
	<h2>Intervention en Attente</h2>
	<span>De: <?= $client['nom'] ?> <?= $client['prenom'] ?></span>
	<span>mail: <?= $client['email'] ?></span>
	<span>n° tel: <?= $client['tel'] ?></span>
	<span>code postal: <?= $client['code_postal'] ?></span>
	<span>Produit: <?= $produit['nom_produit'] ?></span>
	<span>Marque: <?= $produit['marque'] ?></span>
	<span>Etat: <?= $produit['etat'] ?></span>
	<span>Catégorie: <?= $produit['categorie'] ?></span>
	<span>Date de: <?= $intervention['date_creation_intervention'] ?></span>
	<span>Description</span>
	<span><?= $intervention['description'] ?></span>

	<form method="post" action="controleur/traitement.php">
		<label>Date de l'intervention :</label>
		<input type="date" name="dateinter" required />
		
		<label>Prix de l'intervention</label>
		<input type="number" name="prixinter" required />
		
		<label>Durée de l'intervention :</label>
		<input type="number" name="dureeinter" required />

		<input type="hidden" name="idinter" value="<?= $intervention['idintervention'] ?>">

		<button type="submit" name="action" value="accepterPanne">Accepter la Panne</button>
	</form>
</main>