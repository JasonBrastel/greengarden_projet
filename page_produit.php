<?php
session_start();
require_once("dao.php");

$dao = new DAO();
$dao->connexion();

// Récupérer les résultats de la requête
$productsUnique = $dao->get_productSheet();

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
    <main>
        <section>
            <article>
            <?php foreach ($productsUnique as $productUnique) { ?>
                <h2><?php echo $productUnique['Nom_Long']; ?></h2>

                <img src="images/<?php echo $productUnique['Photo'];?>" alt="Image du produit">
                <p><?php echo $productUnique['Ref_fournisseur']; ?></p>
                
                <?php } ?>
           
            </article>
        </section>
    </main>
</body>
</html>
