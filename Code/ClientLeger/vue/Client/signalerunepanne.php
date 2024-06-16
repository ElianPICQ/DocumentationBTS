<main id="signaler-une-panne">

    <div id="signaler-une-panne-container">
        <h2>Signaler une Panne</h2>
        <p>Bienvenue sur la page de signalement de panne. Si vous rencontrez des problèmes avec l'un de nos produits, veuillez remplir le formulaire ci-dessous pour nous informer de la panne.</p>

        <form method="post" action="controleur/traitement.php">
            <label for="produit">Produit:</label>
            <input type="text" name="produit" required />

            <label for="marque">Marque:</label>
            <input type="text" name="marque" required />

            <label for="categorie">Catégorie:</label>
            <select name="categorie" required>
                <option value="electronique">Électronique</option>
                <option value="logiciel">Logiciel</option>
                <option value="materiel">Matériel</option>
                <option value="reseau">Réseau</option>
            </select>

            <label for="etat">État:</label>
            <select name="etat" required>
                <option value="neuf">Neuf</option>
                <option value="occasion">Occasion</option>
                <option value="inconnu">Inconnu</option>
            </select>
<!--
            <label for="image">Joindre une image:</label>
            <input type="file" name="image" accept="image/" id="image" style="display: none;">
            <button type="button" onclick="document.getElementById('image').click()">Parcourir</button>
-->
            <h3>Description du Problème</h3>
            <textarea name="description" rows="4" cols="50" required></textarea>

            <button id="signaler-une-panne-submit-btn" type="submit" name="action" value="signalerPanne">Signaler Panne</button>
        </form>
    </div>

</main>
