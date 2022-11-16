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
        // Requette des posts
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT Title, Date, Comment, Author, image, Id FROM post ORDER BY Date DESC";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute();

        // Requette des commentaires
        $sql2 = "SELECT Id, contenu, sender, article_id, parent_id, date FROM commentaire ORDER BY Date DESC";
        // Préparation de la requête avec les marqueurs
        $resultat2 = $base->prepare($sql2);
        $resultat2->execute();

        // Si il y a des publications
        if ($resultat->rowCount() > 0) {
            // Tant qu'il y en a on les récupère puis les affichent
            while ($ligne = $resultat->fetch()) {
                $date = date_format(date_create($ligne['Date']), 'd-m-Y H:i:s');

                echo '<p>Titre: ' . $ligne['Title'] . '</p>' .
                    '<p>Commentaire: ' . $ligne['Comment'] . '</p>' .
                    '<p>Date: ' . $date . '</p>' .
                    '<img src="../img/' . $ligne['image'] . '">';
                if (isset($_SESSION['pseudo'])) {
                    if ($_SESSION['pseudo'] == $ligne['Author'] || $_SESSION['droit'] === "admin") {
                        echo '<br> <a id="espacement" href="../modifier/index.php?id=' . $ligne['Id'] . '">Modifier</a>';
                        echo '<a href="../supprimer/index.php?id=' . $ligne['Id'] . '">Supprimer</a>';
                    }
                    echo '<div id="commentaires"><form action="./commentaires\traitement_commentaire.php" method="post">
                    <label for="commentaire">
                        Commentaire :<input type="text" name="commentaire" id="commentaire" required>
                    </label>
                    <button type="submit">Envoyer</button>
                </form>';


                    // Si il y a des publications
                    if ($resultat2->rowCount() > 0) {
                        // Tant qu'il y en a on les récupère puis les affichent
                        while ($ligne2 = $resultat2->fetch()) {
                            // Affichage des commentaires
                            echo 'coucou';
                        }
                    } else {
                        echo "<p>Pas de commentaire sur ce post</p>";
                    }
                    echo '</div>';
                }
            }
        } else {
            echo "<br> <p>Il n'y a aucune publication</p>";
        }
        $resultat2->closeCursor();
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