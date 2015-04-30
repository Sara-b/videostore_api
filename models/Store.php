<?php 

/**
* 
*/
class Store
{
	
	public static function get_all_store(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM stores");
      // l'execution 
    $requete->execute();
    $stores = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    return $stores;
  }

  public static function get_store_by_id($id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM stores WHERE id=:id");
      // l'execution 
    $requete->bindParam(':id', $id);
    $requete->execute();
    $store = $requete->fetch(PDO::FETCH_ASSOC);
    
    return $store;
  }
}

?>