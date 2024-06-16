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

?>

<main id="accepter-une-panne">
	<div>
		<h2>Corrigez les pannes !</h2>

		<div class="intervention-card-container">
		<?php
		$lesInterventions = $interventionControleur->getInterventionStatut("en attente");

		foreach ($lesInterventions as $uneIntervention)
		{
			$leProduit = $produitControleur->getProduitById($uneIntervention["idproduit"]);
			$leClient = $utilisateurControleur->getUtilisateurById($uneIntervention["idclient"])
		?>
			<a href="index.php?page=detailinter&idinter=<?= $uneIntervention['idintervention'] ?>">
			<div class="intervention-card">
				<h4><?= $leProduit["nom_produit"] ?></h4>
				<span>Marque: <?= $leProduit["marque"] ?></span>
				<span>Catégorie: <?= $leProduit["categorie"] ?></span>
				<span><?= $leProduit["etat"] ?></span>
				<span>De: <?= $leClient["nom"] ?> <?= $leClient["prenom"] ?></span>
				<span><?= $uneIntervention["statut"] ?></span>
			</div>
			</a>
		<?php
		}
		?>
		</div>
	</div>
</main>