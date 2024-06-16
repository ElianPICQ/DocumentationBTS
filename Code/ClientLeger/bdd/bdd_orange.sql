DROP DATABASE IF EXISTS ClientLeger;
CREATE DATABASE ClientLeger;
USE ClientLeger;

CREATE TABLE Utilisateur (
    idutilisateur INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    tel VARCHAR(20),
    mot_de_passe VARCHAR(50) NOT NULL,
    role ENUM ('client', 'technicien', 'administrateur') NOT NULL,
    PRIMARY KEY (idutilisateur)
);

CREATE TABLE Client (
    idclient INT NOT NULL,
    code_postal INT,
    date_naissance DATE,
    PRIMARY KEY (idclient),
    FOREIGN KEY (idclient) REFERENCES Utilisateur(idutilisateur)
);

CREATE TABLE Technicien (
    idtechnicien INT NOT NULL,
    competence VARCHAR(50) NOT NULL,
    date_embauche date NOT NULL, 
    PRIMARY KEY (idtechnicien),
    FOREIGN KEY (idtechnicien) REFERENCES Utilisateur(idutilisateur)
);

CREATE TABLE Produit (
    idproduit INT NOT NULL AUTO_INCREMENT,
    nom_produit VARCHAR(100) NOT NULL,
    marque VARCHAR(200) NOT NULL,
    url_image VARCHAR(255),
    etat ENUM ("neuf", "occasion", "inconnu") NOT NULL, 
    categorie ENUM ("electronique", "logiciel", "materiel", "reseau") NOT NULL,
    idclient INT NOT NULL,
    FOREIGN KEY (idclient) REFERENCES Client(idclient),
    PRIMARY KEY (idproduit)
);

CREATE TABLE intervention (
    idintervention INT NOT NULL AUTO_INCREMENT,
    date_creation_intervention DATETIME NOT NULL,
    date_intervention_acceptee DATETIME,
    date_intervention DATETIME,
    prix_intervention DECIMAL(8, 2),
    duree INT,  
    description TEXT, 
    statut ENUM ("en attente", "acceptee", "en cours", "terminee", "refusee") NOT NULL,
    idproduit INT NOT NULL,
    idtechnicien int,
    idclient INT NOT NULL,
    PRIMARY KEY (idintervention),
    FOREIGN KEY (idproduit) REFERENCES Produit(idproduit),
    FOREIGN KEY (idtechnicien) REFERENCES Technicien(idtechnicien),
    FOREIGN KEY (idclient) REFERENCES Client(idclient)
);

CREATE TABLE grainSel (
    nb VARCHAR(20) PRIMARY KEY
);

insert into grainSel values ("1234567890");



/******************/
/**** TRIGGERS ****/
/******************/

/* Cette trigger sert à crypter les mots de passe à chaque ajout
 * d'un enregistrement dans la table "Utilisateur"
*/
delimiter $ 
    CREATE TRIGGER crypter_mdp BEFORE INSERT ON Utilisateur 
    for each row 
    begin 
        DECLARE nbsel VARCHAR(255);
        SELECT nb INTO nbsel FROM grainSel; 

        SET NEW.mot_de_passe = md5(concat(NEW.mot_de_passe, nbsel));
    end $
delimiter ;

/* Cette trigger sert à supprimer l'enregistrement dans la table "Utilisateur"
 * correspondant à celui supprimé dans la table "Client"
*/
delimiter $ 
    CREATE TRIGGER delete_client AFTER DELETE ON Client 
    for each row 
    begin
        DELETE FROM Utilisateur WHERE idutilisateur = OLD.idclient;
    end $
delimiter ;

/* Cette trigger sert à supprimer l'enregistrement dans la table "Utilisateur"
 * correspondant à celui supprimé dans la table "Technicien"
*/
delimiter $ 
    CREATE TRIGGER delete_technicien AFTER DELETE ON Technicien
    for each row 
    begin
        DELETE FROM Utilisateur WHERE idutilisateur = OLD.idtechnicien;
    end $
delimiter ;

/* Cette trigger sert à supprimer l'enregistrement dans la table "Produit"
 * correspondant à celui présent dans la table "Intervention" lors de sa
 * suppression
*/
delimiter $ 
    CREATE TRIGGER delete_produit AFTER DELETE ON Intervention
    for each row 
    begin
        DELETE FROM Produit WHERE idproduit = OLD.idproduit;
    end $
delimiter ;





CREATE VIEW lesClients AS (
    SELECT * FROM Utilisateur, Client WHERE idutilisateur = idclient
);
CREATE VIEW lesTechniciens AS (
    SELECT * FROM Utilisateur, Technicien WHERE idutilisateur = idtechnicien
);


CREATE VIEW lesInterventions AS (
    SELECT i.idintervention, p.marque, p.nom_produit, p.etat, p.categorie, i.date_creation_intervention, i.date_intervention_acceptee,
        i.date_intervention, i.prix_intervention, i.duree, i.description, i.statut, c.nom as nomClient, t.nom as nomTech
    FROM intervention i, produit p, lesClients c, lesTechniciens t
    WHERE i.idproduit = p.idproduit AND i.idclient = c.idutilisateur
);


/* Création d'un client */
INSERT INTO Utilisateur VALUES (null, "NOM", "Prenom", "client@client.com", "0123456789", "123", "client");
INSERT INTO Client VALUES (1, "75013", "1982-02-25");


/* Création d'un technicien */
INSERT INTO Utilisateur VALUES (null, "NOM", "Prenom", "mail@mail.com", "01010101", "123", "technicien");
INSERT INTO Technicien VALUES (2, "Materiel", "2020-07-12");