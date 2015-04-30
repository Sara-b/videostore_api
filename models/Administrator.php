<?php
/**
* 
*/
class Administrator
{
	
  public static function get_all_administrators(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM administrator");
      // l'execution 
    $requete->execute();
    $administrators = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    return $administrators;
  }

  public static function get_administrator_by_id($id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM administrator 
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
    
    $requete = $bdd->prepare("SELECT * FROM administrator
                                LEFT JOIN stores ON stores.id = administrator.id_store
                                WHERE administrator.id_store=:store_id");
      // l'execution 
    $requete->bindParam(':store_id', $store_id);
    $requete->execute();
    $administrators = $requete->fetch(PDO::FETCH_ASSOC);
    
    return $administrators;
  }
}

?>