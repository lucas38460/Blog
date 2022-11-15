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
            $sql = "SELECT * FROM login WHERE Identifiant = :Identifiant AND Password = :Password";
            // Préparation de la requête avec les marqueurs
            $resultat = $base->prepare($sql);
            $resultat->execute(array('Identifiant' => $_POST['Identifiant'], 'Password' =>  htmlentities(hash("sha256", $_POST['Password']))));
            // Si le compte existe et n'est pas en double
            if ($resultat->rowCount() == 1) {
                $_SESSION['pseudo'] = $_POST['Identifiant'];
                header("Location:../page/index.php");
            }
            // Sinon Renvoie que le login est incorrect
            else {
                header("Location:index.php?Login=incorrect");
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