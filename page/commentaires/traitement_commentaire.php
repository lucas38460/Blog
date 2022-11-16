<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php

    // Vérifie si il y a bien un commentaire d'envoyé
    if (isset($_POST['commentaire'])) {
        try {
            $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO commentaire (Id, contenu, sender, article_id, parent_id, date) VALUES (:id, :contenu, :sender, :article_id, :parent_id, :date)";
            // Préparation de la requête avec les marqueurs
            $resultat = $base->prepare($sql);
            $resultat->execute(array('id' => uniqid(), 'contenu' => htmlentities($_POST['commentaire']), 'sender' => $_SESSION['pseudo'], 'article_id' => 'mel', 'parent_id' => 'parent', 'date' => date('Y-m-d H:i:s')));
            $resultat->closeCursor();
            // Redirection vers le blog après l'envoie du post
            header("Location:../affichage.php");
        } catch (Exception $e) {
            // message en cas d'erreur
            die('Erreur : ' . $e->getMessage());
        }
    }

    ?>
</body>

</html>