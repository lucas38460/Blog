<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>
    <!-- Redirection pour ajouter des publications -->
    <?php
    if (isset($_SESSION['pseudo'])) {
        echo "<a href='./index.php'>Ajouter une publication</a>";
        echo "<br>";
        echo "<a href='./logout.php'>Se déconnecter</a>";
    } else {
        echo "<a href='.././login/index.php'>Se connecter</a>";
        echo "<br>";
        echo "<a href='.././register/index.php'>Se créer un compte</a>";
    }
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT Title, Date, Comment, Author, image, Id FROM post ORDER BY Date DESC";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute();
        // Si il y a des publications
        if ($resultat->rowCount() > 0) {
            // Tant qu'il y en a on les récupère puis les affichent
            while ($ligne = $resultat->fetch()) {
                $date = date_format(date_create($ligne['Date']), 'd-m-Y H:i:s');

                echo '<p>Titre: ' . $ligne['Title'] . '</p>' .
                    '<p>Date: ' . $date . '</p>' .
                    '<p>Commentaire: ' . $ligne['Comment'] . '</p>' .
                    '<img src="../img/' . $ligne['image'] . '">';
                if (isset($_SESSION['pseudo'])) {
                    if ($_SESSION['pseudo'] == $ligne['Author'] || $_SESSION['droit'] === "admin") {
                        echo '<br> <a id="espacement" href="../modifier/index.php?id=' . $ligne['Id'] . '">Modifier</a>';
                        echo '<a href="../supprimer/index.php?id=' . $ligne['Id'] . '">Supprimer</a>';
                    }
                }
            }
        } else {
            echo "<br> <p>Il n'y a aucune publication</p>";
        }
        $resultat->closeCursor();
    } catch (Exception $e) {
        // message en cas d'erreur
        die('Erreur : ' . $e->getMessage());
    }
    ?>
</body>
<style>
    img {
        max-width: 200px;
    }

    a {
        text-decoration: none;
        color: blue;
    }

    #espacement {
        margin-right: 80px;
    }
</style>

</html>