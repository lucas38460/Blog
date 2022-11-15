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

    //  
    // Lire les donnés pour les afficher dans la page de modification
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT Title, Comment, image FROM post WHERE Id = :id";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('id' => $_SESSION['id']));
        while ($ligne = $resultat->fetch()) {
            // Redirection sur le blog
            echo '<form action="traitement.php" method="post" enctype="multipart/form-data">';
            //  Titre a modifier de la publication
            echo '<label for="title" value="' . $ligne['Title'] . '">Nouveau Titre :
                <input type="text" name="title" id="title">
            </label>';
            // Saut de ligne
            echo '<br>';
            // Commentaire a modifier de la publication
            echo '<label for="commentmodify" placeholder="' . $ligne['Comment'] . '">Nouveau Commentaire:</label> <br>
            <textarea id="commentmodify" name="commentmodify" rows="5" cols="33" required></textarea>';
            // Saut de ligne
            echo '<br>';
            // Image du blog
            echo "<img src='../img/" . $ligne['image'] . "'>";
            // Saut de ligne
            echo '<br>';
            //  Information pour l'utilisateur
            echo '<p>Si vous voulez changer l\'image</p>';
            // Image a modifier du blog
            echo '<input type="file" name="imgmodify" required>';
            // Saut de ligne
            echo '<br>';
            echo '    <a href="../page/affichage.php">Arrêter les modifications sans enregistrer</a>
            </form>';
        }
        $resultat->closeCursor();
    } catch (Exception $e) {
        // message en cas d'erreur
        die('Erreur : ' . $e->getMessage());
    }
    ?>
</body>

</html>