<?php

class DAO
{
    /* Paramètres de connexion à la base de données 
	Dans l'idéal, il faudrait écrire les getters et setters correspondants pour pouvoir en modifier les valeurs
	au cas où notre serveur change
	*/
    //paramètres de connexion à la base de donnée

    private $host = "db";
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
    public function getResults($query, $params = array()) {
        $results = array();
    
        $stmt = $this->bdd->prepare($query);
    
        if (!$stmt) {
            $this->error = $this->bdd->errorInfo();
            return false;
        }
    
        // Liaison des paramètres dans la requête
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    
        // Exécution de la requête
        if (!$stmt->execute()) {
            $this->error = $stmt->errorInfo();
            return false;
        }
    
        // Récupération des résultats
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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


    // Méthode pour récupérer les erreurs
    public function getError() {
        return $this->error;
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
public function get_productSheet()
{
    $productId = $_GET['Id_produit']; 

    $sql = "SELECT Nom_Long, Photo, Ref_fournisseur FROM `t_d_produit` WHERE Id_produit = :productId";
    $query = $this->bdd->prepare($sql);
    $query->bindParam(':productId', $productId, PDO::PARAM_INT);
    
    if (!$query->execute()) {
        throw new Exception('Erreur lors de l\'exécution de la requête : ' . implode(', ', $query->errorInfo()));
    }

    return $query->fetchAll(PDO::FETCH_ASSOC);
}



//Requete liste déroulante par catégorie


public function get_listCategories(){

$sql = "SELECT Id_Categorie,Libelle FROM t_d_categorie";
return $this->getResults($sql);
    }

// Requete pour afficher produit par categorie
public function getProductsByCategory($categoryId) {
    $sql = "SELECT Id_produit, Nom_court, Photo, SUM(Prix_Achat * Taux_TVA / 100) AS TVA, 
            SUM(Prix_Achat + (SELECT SUM(Prix_Achat * Taux_TVA / 100) FROM t_d_produit)) AS TotalTTC 
            FROM t_d_produit 
            WHERE Id_Categorie = :categoryId
            GROUP BY Nom_long";

    
    $query = $this->bdd->prepare($sql);
    $query->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $query->execute();

    // Récupérez les résultats
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

public function executeQuery($sql, $params = array()) {
    // Assurez-vous que la connexion est établie
    $this->connexion();

    $stmt = $this->bdd->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    if ($stmt->execute()) {
        return true;
    } else {
        $this->error = $stmt->errorInfo();
        return false;
    }
}

//Inscription utilisateur
public function inscriptionUtilisateur($login, $mot_de_passe) {
    // Hashage du mot de passe avant l'insertion dans la base de données
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Requête d'insertion
    $sql = "INSERT INTO t_d_user (Login, Password) VALUES (:login, :password)";

    // Paramètres à lier dans la requête
    $params = array(':login' => $login, ':password' => $mot_de_passe_hash);

    // Exécution de la requête avec gestion des erreurs
    return $this->executeQuery($sql, $params);
}


//connexion user

public function connexionUtilisateur($login, $mot_de_passe) {
    $this->connexion(); // Assurez-vous que la connexion est établie

    $sql = "SELECT * FROM t_d_user WHERE Login = :login";
    $params = array(':login' => $login);

    $result = $this->getResults($sql, $params);

    if (!empty($result)) {
        $user = $result[0];
        if (password_verify($mot_de_passe, $user['Password'])) {
            return $user;
        }
    }

    return null;
}

}
    


    



   









