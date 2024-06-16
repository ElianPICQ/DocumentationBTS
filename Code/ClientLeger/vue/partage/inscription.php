<div id= "inscription">

	<div class="connexion_form_container">

		<div class="connexion_form">
			<h2 class="page-title"> Créer un compte </h2>

			<form method="POST" action="controleur/traitement.php">

			<div class="login-container">
				<input id="inscription-nom" class="login-input" type="text" name="nom" placeholder=" " required />
				<label for="inscription-nom" class="login-label"><span class="required-field">*</span>Nom</label>
			</div>
			<div class="login-container">
				<input id="inscription-prenom" class="login-input" type="text" name="prenom" placeholder=" " required />
				<label for="inscription-prenom" class="login-label"><span class="required-field">*</span>Prenom</label>
			</div>
			<div class="login-container">
				<input id="inscription-email" class="login-input" type="email" name="email" placeholder=" " required />
				<label for="inscription-email" class="login-label"><span class="required-field">*</span>Email</label>
			</div>
			<div class="login-container">
				<input id="inscription-mdp" class="login-input" type="password" name="mdp" placeholder=" " required />
				<label for="inscription-mdp" class="login-label"><span class="required-field">*</span>Mot de passe</label>
			</div>
			<div class="login-container">
				<input id="inscription-mdp2" class="login-input" type="password" name="mdp2" placeholder=" " required />
				<label for="inscription-mdp2" class="login-label"><span class="required-field">*</span>Confirmer le Mot de passe</label>
			</div>
			<div class="login-container">
				<input id="inscription-tel" class="login-input" type="text" name="tel" placeholder=" " />
				<label for="inscription-tel" class="login-label">Numéro de téléphone</label>
			</div>
			<div class="login-container">
				<input id="inscription-adresse" class="login-input" type="text" name="code_postal" placeholder=" " />
				<label for="inscription-adresse" class="login-label">Code Postal</label>
			</div>
			<div class="login-container">
				<input id="inscription-age" class="login-input" type="date" name="date_naissance" placeholder=" " />
				<label for="inscription-age" class="login-label">Date de naissance</label>
			</div>
			
			<div class="login-btns">
				<button type="reset" class="reset-btn">Annuler</button>
				<button type="submit" class="confirm-btn" name="action" value="inscrire">Confirmer</button>
			</div>

			<p class="required-field-legende">* Ces champs sont obligatoires</p>

			<input type="hidden" name="role" value="client" />

			</form>
		</div>
	</div>


	<div class="connexion_bg">
		<div class="logo-inscription"></div>
		<img src="http://localhost/ClientLeger/public/img/bg_inscription.svg" />
		<div class="goto-inscription-connexion">
			<p>Déjà un compte?</p>
			<span>
				<a href="index.php?page=connexion">Se connecter</a>
			</span>
		</div>
	</div>
</div>