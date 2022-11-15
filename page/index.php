<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['pseudo'])) {
        header("Location:./affichage.php");
    }
    ?>
    <!-- Redirection sur le blog -->
    <a href="affichage.php">Voir le Blog</a>
    <form action="envoie.php" method="post" enctype="multipart/form-data">
        <!-- Titre de la publication -->
        <label for="title">Titre :
            <input type="text" name="title" id="title" required>
        </label>
        <br>
        <!-- Commentaire de la publication -->
        <label for="comment">Commentaire:</label> <br>
        <textarea id="comment" name="comment" rows="5" cols="33" required></textarea>
        <br>
        <!-- Image du blog -->
        <input type="file" name="img">
        <button type="submit">Envoyer</button>
        <br>
        <a href='./logout.php'>Se déconnecter</a>

    </form>
    <br>
</body>

</html>