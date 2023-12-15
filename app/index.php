<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("dao.php");
require_once("session.php");

$dao = new DAO();
$dao->connexion();


$list_categories = $dao->get_listCategories();

// Récupérer la catégorie sélectionnée
$category = isset($_POST['selectedCategory']) ? $_POST['selectedCategory'] : 'all';

// Récupérer les produits en fonction de la catégorie sélectionnée
if ($category == 'all') {
    $products = $dao->get_PrintProduct();
} else {
    $products = $dao->getProductsByCategory($category);
}

$userIsLoggedIn = isset($_SESSION['login']);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Tableau</title>
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
         <form method="POST" action="">
                <select name="selectedCategory" class="form-control" onchange="submit()">
                    <option value="all" <?php echo ($category === 'all') ? 'selected' : ''; ?>>Tous les produits</option>
                    <?php foreach ($list_categories as $list_categorie) { ?>
                        <option value="<?php echo $list_categorie["Id_Categorie"]; ?>" <?php echo ($category == $list_categorie["Id_Categorie"]) ? 'selected' : ''; ?>>
                            <?php echo $list_categorie["Libelle"]; ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
       
        <section class ="list_produits">
            <?php if (empty($products)) { ?>
                <p>Aucun produit disponible pour cette catégorie.</p>
            <?php } else { ?>
                <?php foreach ($products as $product) { ?>
                    <article class="card">
                        <a href="page_produit.php?Id_produit=<?php echo $product['Id_produit']; ?>">
                            <div class="card_img">
                                <img src="images/<?php echo $product['Photo']; ?>" alt="Image du produit">
                            </div>
                            <div class="card_info">
                                <h2><?php echo $product['Nom_court']; ?></h2>
                                <h3>Prix</h3>
                                <p><?php echo $product['TotalTTC'], " €"; ?></p>
                            </div>
                        </a>
                    </article>
                <?php } ?>
            <?php } ?>
        </section>
    </main>

</body>

</html>
