<?php

    try {
        $url = "mysql:host=localhost:3307;dbname=ClientLeger";
        $user = "root";
        $mdp = "";
        $bdd = new PDO($url, $user, $mdp);
    } catch (PDOException $e) {
        print "Erreur de connexion a la BDD: " . $e->getMessage() . "<br/>";
        die();
    }

?>