<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
</head>

<body>
    <?php
    $_SESSION['id'] = $_GET['id'];
    if (!isset($_SESSION['pseudo'])) {
        header("Location:../login/index.php");
    }

    // Lire les donnés pour les afficher dans la page de modification
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT Title, Comment, image FROM post WHERE Id = :id";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('id' => $_SESSION['id']));
        while ($ligne = $resultat->fetch()) {
            echo '<p>Ancien titre:' . $ligne['Title'] . "</p>";
            echo '<p>Ancien commentaire:' . $ligne['Comment'] . "</p>";
            echo '<p>Ancienne image:</p>" <br>';
            echo "<img src='../img/" . $ligne['image'] . "'>" . '<br />';
        }
        $resultat->closeCursor();
    } catch (Exception $e) {
        // message en cas d'erreur
        die('Erreur : ' . $e->getMessage());
    }
    ?>
    <!-- Redirection sur le blog -->
    <form action="traitement.php" method="post" enctype="multipart/form-data">
        <!-- Titre a modifier de la publication -->
        <label for="title">Nouveau Titre :
            <input type="text" name="title" id="title" required>
        </label>
        <br>
        <!-- Commentaire a modifier de la publication -->
        <label for="commentmodify">Nouveau Commentaire:</label> <br>
        <textarea id="commentmodify" name="commentmodify" rows="5" cols="33" required></textarea>
        <br>
        <!-- Image a modifier du blog -->
        <input type="file" name="imgmodify" required>
        <br>
        <button type="submit">Remplacer</button>
        <br>
        <a href='../page/affichage.php'>Arrêter les modifications sans enregistrer</a>
    </form>
</body>
<style>
    img {
        max-width: 200px;
    }
</style>

</html>