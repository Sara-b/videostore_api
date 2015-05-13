<?php
/**
* 
*/
class Administrator
{
	
  public static function get_all_administrators(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM administrators");
      // l'execution 
    $requete->execute();
    $administrators = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    return $administrators;
  }

  public static function get_administrator_by_id($id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM administrators 
                                LEFT JOIN stores ON stores.id = administrator.id_store
                                WHERE administrator.id=:id");
      // l'execution 
    $requete->bindParam(':id', $id);
    $requete->execute();
    $administrator = $requete->fetch(PDO::FETCH_ASSOC);
    
    return $administrator;
  }

  public static function get_administrators_by_store($store_id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM administrators
                                LEFT JOIN stores ON stores.id = administrator.id_store
                                WHERE administrator.id_store=:store_id");
      // l'execution 
    $requete->bindParam(':store_id', $store_id);
    $requete->execute();
    $administrators = $requete->fetch(PDO::FETCH_ASSOC);
    
    return $administrators;
  }


public static function connexion($mail,$password){
    global $bdd;
    
    //on passe par le formulaire
    if(isset($mail) AND $mail!="" AND isset($password) AND $password!="") // On a le pseudo et mdp
      {
        // On récupère tout le contenu de la table 
        $req = $bdd->prepare('SELECT * FROM administrators WHERE mail=:mail AND password=:password LIMIT 1'); 
        //on passe en paramètre de la requete nos variables $_POST
        $req->execute(array(
          'mail' => $mail,
          'password' => $password
          ));
        if($user=$req->fetch(PDO::FETCH_ASSOC)){
          return $user;
        }
        else return "false";
          
      }
      else{
        return "false";
      }
  }
}
?>