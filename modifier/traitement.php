<?php session_start();
if (isset($_FILES['imgmodify'])) {
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
    try {
        $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE post SET Comment = :newcomment, Title = :newtitle, image = :newimage WHERE Id = :id";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('newcomment' => htmlentities($_POST['commentmodify']), 'newtitle' => htmlentities($_POST['title']), 'newimage' => $img_name, 'id' => $_SESSION['id']));
        unset($_SESSION['id']);
        // Suppression de l'image de base dans les fichiers
        unlink('../img/' . $_['']);
        header("Location:../page/affichage.php");
        $resultat->closeCursor();
    } catch (Exception $e) {
        // message en cas d’erreur
        die('Erreur : ' . $e->getMessage());
    }
}
//  else {
//     try {
//         $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '');
//         $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $sql = "UPDATE post SET Comment = :newcomment, Title = :newtitle WHERE Id = :id";
//         // Préparation de la requête avec les marqueurs
//         $resultat = $base->prepare($sql);
//         $resultat->execute(array('newcomment' => htmlentities($_POST['commentmodify']), 'newtitle' => htmlentities($_POST['title']), 'id' => $_SESSION['id']));
//         unset($_SESSION['id']);
//         header("Location:../page/affichage.php");
//         $resultat->closeCursor();
//     } catch (Exception $e) {
//         // message en cas d’erreur
//         die('Erreur : ' . $e->getMessage());
//     }
// }
