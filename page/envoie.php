<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verification</title>
</head>

<body>
    <?php

    // Vérifie si il y a bien une image
    if (isset($_FILES['img']['name'])) {
        // Chemin final de l'image
        $chemin_destination = '../img/';
        // Récupération de l'extension
        $extention = explode('.', $_FILES['img']['name'])[1];
        // Récupération du nom de l'image + changement du nom en uniqid()
        $img_name = uniqid() . "." . $extention;
        //déplacement du fichier dans le dossier img
        move_uploaded_file($_FILES["img"]["tmp_name"], $chemin_destination . $img_name);
    }
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO post (Id, Date, Comment, Title, image, Author) VALUES (:id, :date, :comment, :title, :image, :Author)";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('id' => uniqid(), 'date' => date('Y-m-d H:i:s'), 'comment' => htmlentities($_POST['comment']), 'title' => htmlentities($_POST['title']), 'image' => $img_name, 'Author' => $_SESSION['pseudo']));
        $resultat->closeCursor();
        // Redirection vers le blog après l'envoie du post
        header("Location:affichage.php");
    } catch (Exception $e) {
        // message en cas d'erreur
        die('Erreur : ' . $e->getMessage());
    }

    ?>

</body>

</html>