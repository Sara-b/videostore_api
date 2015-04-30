<?php

/**
* 
*/
class Category
{
	
	public static function get_all_categories(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM Categories");
      // l'execution 
    $requete->execute();
    $Categories = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    return $Categories;
  }

}

?>