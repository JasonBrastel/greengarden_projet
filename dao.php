<?php

class DAO
{
    /* Paramètres de connexion à la base de données 
	Dans l'idéal, il faudrait écrire les getters et setters correspondants pour pouvoir en modifier les valeurs
	au cas où notre serveur change
	*/
    //paramètres de connexion à la base de donnée

    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $database = "greengarden";
    private $charset = "utf8";

    //instance courante de la connexion
    private $bdd;

    //stockage de l'erreur éventuelle du serveur mysql
    private $error;

    //constructeur de la classe

    public function __construct()
    {
    }


    //méthode pour récupérer les résultats d'une requête SQL
    public function getResults($query) {
        $results=array();

        $stmt = $this->bdd->query($query);

        if (!$stmt) {
            $this->error=$this->bdd->errorInfo();
            return false;
        } else {
            // fetch uniquement PDO associative 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    /* méthode de connexion à la base de donnée */
    public function connexion()
    {

        try {

            // On se connecte à MySQL
          
            $this->bdd = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset, $this->user, $this->password);
        } catch (Exception $e) {
            // En cas d'erreur, on affiche un message et on arrête tout
            $this->error = 'Erreur : ' . $e->getMessage();
        }

    }

    /* méthode pour fermer la connexion à la base de données */
	public function disconnect()
	{
		$this->bdd = null;
	}






//Page Accueil


//Requette affichage produit avec prix ttc
public function get_PrintProduct(){
    $sql = "SELECT Id_produit,Nom_court, Photo, SUM(Prix_Achat * Taux_TVA / 100) AS TVA, 
            SUM(Prix_Achat + (SELECT SUM(Prix_Achat * Taux_TVA / 100) FROM t_d_produit)) AS TotalTTC 
            FROM t_d_produit 
            GROUP BY Nom_long";

    // Préparez et exécutez la requête
    $query = $this->bdd->prepare($sql);
    $query->execute();

    // Récupérez les résultats
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    // Retournez les résultats
    return $this->getResults($sql);
}


// Requête affichage pour fiche produit

public function get_productSheet() {
    

$sql = "SELECT Nom_Long, Photo, Ref_fournisseur 
FROM `t_d_produit` 
WHERE Id_produit = '" . $_GET['Id_produit'] . "'";

 // Retournez les résultats
    return $this->getResults($sql);
}


    }










