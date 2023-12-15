<?php

require_once 'dao.php';
$dao = new DAO();

// Vérifier si le formulaire a été soumis
if (isset($_POST['login'], $_POST['password'])) {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $mot_de_passe = $_POST['password'];

    // Appeler la méthode d'inscription
    $result = $dao->inscriptionUtilisateur($login, $mot_de_passe);

    // Vérification du résultat de l'inscription
    if ($result) {
        echo 'Inscription réussie !';
    } else {
        echo 'Erreur lors de l\'inscription. ' . $dao->getError();
    }
}

?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>
 <a href="index.php">Retour à l'accueil</a>
 </body>
 </html>