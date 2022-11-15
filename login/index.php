<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <a href="../Register/index.php">Créer un compte</a>
    <a href='../page/affichage.php?nopass="no"'>Voir le blog</a>

    <form action=" verif.php" method="post">
        <!-- Identifiant de la personne -->
        <label for="Identifiant">
            Nom: <input type="text" name="Identifiant" id="Identifiant" required>
        </label>
        <!-- Mot de passe de la personne -->
        <label for="password">
            Password: <input type="Password" name="Password" id="Password" required>
        </label>
        <!-- Vérifier si l'on est inscrit sur la base de donnée -->
        <button type="submit">Vérifier</button>
        <?php
        // Si il n'y est pas
        if (isset($_GET['Login']) && $_GET['Login'] === "incorrect") {
            echo "<p>Login incorrect ou innexistant</p>";
        }
        ?>
</body>

</html>