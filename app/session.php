<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("dao.php");

$dao = new DAO();
$dao->connexion();

if (isset($_POST['login'], $_POST['password'])) {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $mot_de_passe = $_POST['password'];

    // Vérifier les identifiants
    $utilisateur = $dao->connexionUtilisateur($login, $mot_de_passe);

    if ($utilisateur !== null) {
        // Identifiants valides, stocker les informations dans la session
        $_SESSION['user_id'] = $utilisateur['Id_User'];
        $_SESSION['user_login'] = $utilisateur['Login'];

        echo "Connexion réussie";
  
        header("Location: index.php");
        exit();
    } else {
        echo "Identifiants incorrects";
    }
}
?>
