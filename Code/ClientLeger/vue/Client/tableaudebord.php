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

<main id="tableau-de-bord">
	<div>
		<h2>Bienvenue <?= $_SESSION['prenom'] . " " . $_SESSION['nom'] ?></h2>

		<div class="intervention-card-container">
	<?php
		$mesinterventions = array(); 

		if ($_SESSION['role'] == 'client')
			$mesInterventions = $interventionControleur->getInterventionClient($_SESSION['idutilisateur']);
		else if ($_SESSION['role'] == 'technicien')
			$mesInterventions = $interventionControleur->getInterventionTechnicien($_SESSION['idutilisateur']);

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
		<?php	} ?>
				
				<span>Prix: <?= $uneIntervention["prix_intervention"] ?></span>
				<span>durée: <?= $uneIntervention["duree"] ?> h</span>
				<span><?= $uneIntervention["statut"] ?></span>

		<?php
			if ($_SESSION['role'] == 'technicien') { 
/*
	Le technicien pourra supprimer l'intervention si celle ci a été rejetée
*/
				if ($uneIntervention['statut'] == "refusee") { ?>

				<form class="tech-btns-card" method="post" action="controleur/traitement.php">
					<input type="hidden" name="idintervention" value="<?= $uneIntervention["idintervention"] ?>" />
					<button type="submit" name="action" value="supprimerInter" class="tech-btns-card-btn">Supprimer</button>
				</form>
		<?php	}

/*
	Le Technicien a la possibilité d'annuler son inter (qui repassera en attente) ou de la terminer
*/
				else { ?>
				<form class="tech-btns-card" method="post" action="controleur/traitement.php">
					<input type="hidden" name="idintervention" value="<?= $uneIntervention["idintervention"] ?>" />
					<button type="submit" name="action" value="annulerInter" class="tech-btns-card-btn">Annuler</button>

					<button type="submit" name="action" value="terminerInter" class="tech-btns-card-btn">Terminer</button>
				</form>
		<?php	} ?>
	<?php	} ?>

<!--
	Le Client peut supprimer l'intervention tant qu'elle est "en attente"
-->
		<?php
			if ($_SESSION['role'] == 'client' && ($uneIntervention['statut'] == "en attente" && $uneIntervention['prix_intervention'] == 0)) { ?>

				<form class="client-btns-card" method="post" action="controleur/traitement.php">
					<input type="hidden" name="idintervention" value="<?= $uneIntervention["idintervention"] ?>" />
					<button type="submit" name="action" value="supprimerInter" class="client-btns-card-btn">Supprimer</button>
				</form>
	<?php	}
		?>

<!--
	Lorqu'une inter est acceptée par un technicien un client peut choisir de confirmer l'inter ou de la rejeter.
-->
		<?php
			if ($_SESSION['role'] == 'client' && $uneIntervention['statut'] == "acceptee" && $uneIntervention['prix_intervention'] != 0) { ?>
				<form class="tech-btns-card" method="post" action="controleur/traitement.php">
					<input type="hidden" name="idintervention" value="<?= $uneIntervention["idintervention"] ?>" />
					<button type="submit" name="action" value="rejeterInter" class="client-btns-card-btn">Rejeter</button>
					<button type="submit" name="action" value="confirmerInter" class="client-btns-card-btn">Confirmer</button>
				</form>
	<?php	} ?>

			</div>
	<?php
		}
	?>
		</div>
	</div>
</main>