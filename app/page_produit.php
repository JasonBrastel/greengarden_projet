<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

// Récupérer les résultats de la requête
$productsUnique = $dao->get_productSheet();
$userIsLoggedIn = isset($_SESSION['login']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Produit</title>
    <link rel="stylesheet" href="Styles/style.css">
</head>
<body>
<header class = "container">
        <nav>
            <a href= "index.php">Accueil</a>
            <?php if ($userIsLoggedIn) { ?>
                <a href="deco.php">Déconnexion</a>
            <?php } ?>
            </nav>
  

    <form class = barre_connexion action="connexion.php" method="post">
    <label for="login">Nom :</label>
    <input type="text" name="login" required><br>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" required><br>

    <input type="submit" value="Se connecter">

</form>
 </nav>
    
    </header>
    <main>
        <section class="container_fiche">
            <article class="fiche_produit">
            <?php foreach ($productsUnique as $productUnique) { ?>
                <h2><?php echo $productUnique['Nom_Long']; ?></h2>

                <img class = "img_fiche_produit"src="images/<?php echo $productUnique['Photo'];?>" alt="Image du produit">
                <p><?php echo $productUnique['Ref_fournisseur']; ?></p>
                
                
                <?php } ?>
           
            </article>
        </section>
    </main>
</body>
</html>
