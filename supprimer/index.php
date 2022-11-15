<?php session_start();
if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] = $_GET['id']) {
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM post WHERE id =:id";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('id' =>  $_GET['id']));
        $resultat->closeCursor();
        header("Location:../page/affichage.php");
    } catch (Exception $e) {
        // message en cas d'erreur
        die('Erreur : ' . $e->getMessage());
    }
} else {
    header("Location:../page/affichage.php");
}
