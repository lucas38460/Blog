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

</html>