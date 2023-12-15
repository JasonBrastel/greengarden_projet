<?php
session_start();

// Inclure la classe DAO et créer une instance
require_once 'dao.php';
$dao = new DAO();

// Vérifier si le formulaire a été soumis
if (isset($_POST['login'], $_POST['password'])) {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $mot_de_passe = $_POST['password'];

    // Appeler la méthode de connexion
    $user = $dao->connexionUtilisateur($login, $mot_de_passe);

    // Vérification du résultat de la connexion
    if ($user) {
        // Connexion réussie, établir une session
        $_SESSION['login'] = $user;

        // Rediriger vers la page d'accueil ou autre page souhaitée
        header('Location: index.php');
        exit();
    } else {
        $erreur_message = 'Identifiants incorrects. Veuillez réessayer.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<?php
if (isset($erreur_message)) {
    echo '<p style="color: red;">' . $erreur_message . '</p>';
}
?>

<form action="connexion.php" method="post">
    <label for="login">Nom :</label>
    <input type="text" name="login" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Se connecter">
</form>

</body>
</html>
