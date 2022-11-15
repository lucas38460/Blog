<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login avec la base de donné</title>
</head>

<body>

    <?php
    if (isset($_POST)) {
        try {
            $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT `identifiant`, `password` FROM login WHERE identifiant = :identifiant";
            // Préparation de la requête avec les marqueurs
            $resultat = $base->prepare($sql);
            $resultat->execute(array('identifiant' => $_POST['identifiant']));
            // Si le compte existe déjà (a été créé aumoins)
            if ($resultat->rowCount() == 1) {
                header("Location:index.php?Login=existant");
            } else {
                // Creation du compte puisqu'il n'existe pas
                $sql_create = "INSERT INTO login (`id`, `identifiant`, `password`, `role`) VALUES (:id ,:identifiant, :password, :role)";
                $resultat2 = $base->prepare($sql_create);
                $resultat2->execute(array('id' => uniqid(), 'identifiant' => htmlentities($_POST['identifiant']), 'password' => htmlentities(hash("sha256", $_POST['password'])), 'role' => "user"));
                header("Location:../login/index.php?compte=creer");
            }
            $resultat->closeCursor();
        } catch (Exception $e) {
            // message en cas d'erreur
            die('Erreur : ' . $e->getMessage());
        }
    }

    ?>
</body>

</html>