<?php
session_start();

require_once("dao.php");

$dao = new DAO();
$dao->connexion();

$products = $dao->get_PrintProduct();

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
    
<header> 
        <nav>
            <a>Accueil</a>
            <a>lorem</a>
            <a>Ipsum</a>
            <a>Truc</a>
        </nav>
    </header>




    <main>
        <section>
           
            <?php foreach ($products as $product) { ?>
                <article class="card">
                    
                <a href="page_produit.php?Id_produit=<?php echo $product['Id_produit']; ?>">

                    <div class="card_img">
                        <img src="images/<?php echo $product['Photo'];?>" alt="Image du produit">
                    </div>
                    <div class="card_info">
                        <h2><?php echo $product['Nom_court']; ?></h2>
                        <h3>Prix</h3>
                        <p><?php echo $product['TotalTTC']," €"; ?></p>
                    </div>
                </article>
            <?php } ?>
       
        </section>
    </main>
</body>


        </section>
    </table>
</main>
</body>
</html>
