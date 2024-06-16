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

$utilisateurControleur = new UtilisateurControleur($bdd);

if ($_SESSION['role'] == 'client')
	$unClient = $utilisateurControleur->getClientById($_SESSION['idutilisateur']);
else if ($_SESSION['role'] == 'technicien')
	$unTechnicien = $utilisateurControleur->getTechnicienById($_SESSION['idutilisateur']);
?>

<main id="profil">
	<div>
		<h3>Modifiez vos informations</h3>
		<span><?= $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></span>
		<span><?= $_SESSION['email'] ?></span>
<?php
	if ($_SESSION['role'] == 'client') {
?>		
		<span><?= $unClient['tel'] ?></span>
		<span><?= $unClient['code_postal'] ?></span>
		<span><?php
		if ($unClient['date_naissance'])
		{
			$currDate = date('Y-m-d');
			$age = date_diff(date_create($unClient['date_naissance']), date_create($currDate));
			$txt = $unClient['date_naissance'] == 0 ? "" : "ans";
			echo $age->y . $txt;
		}
		?></span>

<?php } else if ($_SESSION['role'] == 'technicien') {
?>
		<span><?= $unTechnicien['tel'] ?></span>
		<span>Compétence: <?= $unTechnicien['competence'] ?></span>
		<span>Date d'embauche: <?= $unTechnicien['date_embauche'] ?></span>
<?php } ?>

		<form method="post" action="controleur/traitement.php" >
			<h3>Changer de mot de passe</h3>
			<input name="currmdp" type="mdp" placeholder="Mot de Passe actuel" required />
			<input name="newmdp" type="mdp" placeholder="Nouveau Mot de Passe" required />
			<input name="newmdp2" type="mdp" placeholder="Retappez le nouveau Mot de Passe" required />

			<button type="submit" name="action" value="changemdp">Confirmer</button>
		</form>

		<form method="post" action="controleur/traitement.php" >
			<h3>Changer de numéro de téléphone</h3>
			<input name="currmdp" type="mdp" placeholder="Mot de Passe actuel" required />
			<input name="newtel" type="text" placeholder="Nouveau numéro" required />

			<button type="submit" name="action" value="changetel">Confirmer</button>
		</form>
<?php
	if ($_SESSION['role'] == 'client') {
?>
		<form method="post" action="controleur/traitement.php" >
			<h3>Changer de code postal</h3>
			<input name="currmdp" type="mdp" placeholder="Mot de Passe actuel" required />
			<input name="newcodepostal" type="text" placeholder="Nouveau Code Postal" required />

			<button type="submit" name="action" value="changercodepostal">Confirmer</button>
		</form>
<?php
	} else if ($_SESSION['role'] == 'technicien') {
?>
		<form method="post" action="controleur/traitement.php" >
			<h3>Changer de compétence</h3>
			<input name="currmdp" type="mdp" placeholder="Mot de Passe actuel" required />
			<input name="newcompetence" type="text" placeholder="Nouvelle compétence" required />

			<button type="submit" name="action" value="changecompetence">Confirmer</button>
		</form>
<?php
	}
?>
	</div>
</main>