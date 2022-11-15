<?php session_start() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement</title>
</head>

<body>
    <a href="../Login/index.php">Se connecter</a>
    <a href='../page/affichage.php?nopass="no"'>Voir le blog</a>
    <form action="creation.php" method="post">
        <!-- Identifiant de la personne -->
        <label for="Identifiant">
            Nom: <input type="text" name="identifiant" id="identifiant" required>
        </label>
        <!-- Mot de passe de la personne -->
        <label for="password">
            Password: <input type="password" name="password" id="password" required>
        </label>
        <button type="submit">Vérifier</button>
        <?php
        if (isset($_GET['Login']) && $_GET['Login'] === "existant") {
            echo "<p>Le login existe déjà</p>";
        }
        ?>
</body>

</html>