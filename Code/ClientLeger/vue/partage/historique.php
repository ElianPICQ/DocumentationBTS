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

<main id="historique">
	<div>
		<h2>Historique</h2>
		
	<?php
		$mesinterventions = array(); 

		if ($_SESSION['role'] == 'client')
			$mesInterventions = $interventionControleur->getInterventionTermineeClient($_SESSION['idutilisateur']);
		else if ($_SESSION['role'] == 'technicien')
			$mesInterventions = $interventionControleur->getInterventionTermineeTechnicien($_SESSION['idutilisateur']);

		$nbInter = $interventionControleur->getNbInterventionClient($_SESSION['idutilisateur'], "terminee");
		$prixTotal = $interventionControleur->getPrixInterventionUtilisateur($_SESSION['idutilisateur'], "terminee");
		$month = date('m');
		$nbInterMois = $interventionControleur->getNbInterventionMoisUtilisateur($_SESSION['idutilisateur'], "terminee", $month);

		?>
		<div style="display: flex; flex-direction: column">
			<span>Total Interventions : <?= $nbInter[0] ?></span>
			<span>Prix Interventions : <?= $prixTotal[0] ?></span>
			<span>Interventions ce mois : <?= $nbInterMois[0] ?></span>
		</div>

		<div class="intervention-card-container">

		<?php
		foreach ($mesInterventions as $uneIntervention)
		{
			$monProduit = $produitControleur->getProduitById($uneIntervention["idproduit"]);
			$letech = $utilisateurControleur->getTechnicienById($uneIntervention["idtechnicien"]);
			$leclient = $utilisateurControleur->getClientById($uneIntervention["idclient"]);
		?>
			<div class="intervention-card">
				<h4><?= $monProduit["nom_produit"] ?></h4>
				<span>Marque: <?= $monProduit["marque"] ?></span>
				<span>Catégorie: <?= $monProduit["categorie"] ?></span>
				<span><?= $monProduit["etat"] ?></span>
				<span>Déposé le: <?= $uneIntervention["date_creation_intervention"] ?></span>
				<span>Accepté pour le: <?= $uneIntervention["date_intervention"] ?></span>

				<!-- On affiche le nom du technicien ou du client en fonction du role de la personne connectée -->
		<?php
				if ($_SESSION['role'] == 'client') {
					$fullname = $letech == null ? "" : $letech['nom'];
					$fullname .= " ";
					$fullname .= $letech == null ? "" : $letech['prenom'];
		?>
				<span>Par: <?= $fullname ?></span>

		<?php	}
				else if ($_SESSION['role'] == 'technicien') {
		?>
				<span>De: <?= $leclient['nom'] ?> <?= $leclient['prenom'] ?></span>
		<?php	}
		?>
				
				<span>Prix<?= $uneIntervention["prix_intervention"] ?></span>
				<span>durée: <?= $uneIntervention["duree"] ?></span>
				<span><?= $uneIntervention["statut"] ?></span>
			</div>
	<?php
		}
	?>
		</div>
	</div>
</main>