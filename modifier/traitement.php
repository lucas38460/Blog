<?php session_start();
if (isset($_FILES['imgmodify']['name'])) {
    // Chemin final de l'image
    $chemin_destination = '../img/';
    // Récupération de l'extension
    $extention = explode('.', $_FILES['imgmodify']['name'])[1];
    // Récupération du nom de l'image + changement du nom en uniqid()
    $img_name = uniqid() . "." . $extention;
    //déplacement du fichier dans le dossier img
    move_uploaded_file($_FILES["imgmodify"]["tmp_name"], $chemin_destination . $img_name);
}
if (isset($_POST['title'])) {
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE post SET Comment = :newcomment, Title = :newtitle, image = :newimage WHERE Id = :id";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('newcomment' => $_POST['commentmodify'], 'newtitle' => $_POST['title'], 'newimage' => $img_name, 'id' => $_SESSION['id']));
        unset($_SESSION['id']);
        echo "post modifié.";
        echo "<br>";
        echo "<a href ='../page/affichage.php'>Voir les modifications</a>";
        $resultat->closeCursor();
    } catch (Exception $e) {
        // message en cas d’erreur
        die('Erreur : ' . $e->getMessage());
    }
}
