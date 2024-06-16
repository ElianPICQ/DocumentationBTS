<!DOCTYPE html>
<head>
	<meta charset="UTF-8" />
	<title>Orange</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link type="text/css" rel="stylesheet" href="public/css/styles.css" />
</head>
<body>
<div id="fullpage">
<header>
	<img src="public/img/logo_Orange.png" alt="logo Orange" width="65%" id="header-logo" />

	<nav>
		<ul>
			<li><a href="index.php?page=tableaudebord">Tableau de Bord</a></li>
			<li><a href="index.php?page=profil">Profil</a></li>
			<?php
			if ($_SESSION['role'] == 'client')
			{ ?>
			<li class="nav_btn"><a href="index.php?page=signalerunepanne">Signaler une Panne</a></li>
			<?php }
			else if ($_SESSION['role'] == 'technicien')
			{ ?>
			<li class="nav_btn"><a href="index.php?page=accepterunepanne">Accepter une Panne</a></li>
			<?php } ?>

			<li><a href="index.php?page=historique">Historique</a></li>
			<li><a href="index.php?page=deconnecter">Se déconnecter</a></li>
		</ul>
	</nav>
</header>