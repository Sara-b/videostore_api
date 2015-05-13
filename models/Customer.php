<?php 
/**
* 
*/
class Customer
{
	public static function get_all_users(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM customers");
      // l'execution 
    $requete->execute();
    $customers = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    return $customers;
  }

  public static function get_user_by_id($id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT cust . * , ctr.name
                              FROM customers AS cust
                              LEFT JOIN countries AS ctr ON ctr.id = cust.id_country
                              WHERE cust.id=:id");
      // l'execution 
    $requete->bindParam(':id', $id);
    $requete->execute();
    $user = $requete->fetch(PDO::FETCH_ASSOC);
    
    return $user;
  }

  public static function create_user($post){
    global $bdd;

    $req = $bdd->prepare("INSERT INTO customers (mail, password, first_name, last_name, id_country, town, address, posteCode, phone) 
                          VALUES (:mail, :password, :first_name, :last_name, 1, :town, :address, :posteCode, :phone)");

    $requete->bindParam(':mail', $post['mail']);
    $requete->bindParam(':password', $post['password']);
    $requete->bindParam(':first_name', $post['first_name']);
    $requete->bindParam(':last_name', $post['last_name']);
    $requete->bindParam(':town', $post['town']);
    $requete->bindParam(':address', $post['address']);
    $requete->bindParam(':posteCode', $post['posteCode']);
    $requete->bindParam(':phone', $post['phone']);
    $req->execute();

    return true;
  }

  public static function connexion($mail,$password){
    global $bdd;
    
    //on passe par le formulaire
    if(isset($mail) AND $mail!="" AND isset($password) AND $password!="") // On a le pseudo et mdp
      {
        // On récupère tout le contenu de la table 
        $req = $bdd->prepare('SELECT * FROM customers WHERE mail=:mail AND password=:password LIMIT 1'); 
        //on passe en paramètre de la requete nos variables $_POST
        $req->execute(array(
          'mail' => $mail,
          'password' => $password
          ));
        if($user=$req->fetch(PDO::FETCH_ASSOC)){
          return $user;
        }
        else return false;
          
      }
      else{
        return false;
      }
  }

  public static function connexion2($mail){
    global $bdd;
    
    //on passe par le formulaire
    if(isset($mail) AND $mail!="" ) // On a le pseudo et mdp
      {
        // On récupère tout le contenu de la table 
        $req = $bdd->prepare('SELECT * FROM customers WHERE mail=:mail'); 
        //on passe en paramètre de la requete nos variables $_POST
        $req->execute(array(
          'mail' => $mail
          ));
        /*if($donnees=$req->fetchAll(PDO::FETCH_ASSOC)){  
          $_SESSION['id']=$donnees['id'];
          $_SESSION['mail']=$donnees['mail'];
          $_SESSION['first_name']=$donnees['first_name'];
          $_SESSION['last_name']=$donnees['last_name'];
        */
        if($user=$req->fetchAll(PDO::FETCH_ASSOC)){
          return $user;
        }
        else return false;
          
      }
      else{
        return false;
      }
  }

  static function update_user($param){
    global $bdd;

    $requete = $bdd->prepare("UPDATE customers
                SET mail=:mail,password=:password,first_name=:first_name,last_name=:last_name, id_country=:id_country, town=:town, address=:address, posteCode=:posteCode, phone=:phone 
                WHERE id=:id");
    // l'execution 
    $requete->bindParam(':mail', $param['mail']);
    $requete->bindParam(':password', $param['password']);
    $requete->bindParam(':first_name', $param['first_name']);
    $requete->bindParam(':last_name', $param['last_name']);
    $requete->bindParam(':id_country', $param['id_country']);
    $requete->bindParam(':town', $param['town']);
    $requete->bindParam(':address', $param['address']);
    $requete->bindParam(':posteCode', $param['posteCode']);
    $requete->bindParam(':phone', $param['phone']);
    $requete->bindParam(':id', $param['id']);
    $requete->execute();
  }

  static function delete_user($param){
    global $bdd;

    $requete = $bdd->prepare("DELETE FROM customers
                WHERE id=:id");
    // l'execution 
    $requete->bindParam(':id', $param['id']);
    $requete->execute();
  }

}

?>