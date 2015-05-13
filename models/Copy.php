<?php

/**
* 
*/
class Copy
{
	
	public static function get_all_copies(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT c.id, m.title, CONCAT(d.first_name,' ',d.last_name) as director, c.status as status, f.type as format
                              FROM copies AS c
                              JOIN movies AS m ON c.id_movie = m.id
                              JOIN directors AS d ON m.id_director = d.id
    						  JOIN formats AS f ON c.id_format = f.id
    						  JOIN stores AS s ON s.id = c.id_store
    						  ORDER BY m.title");
      // l'execution 
    $requete->execute();
    $copies = $requete->fetchAll(PDO::FETCH_ASSOC);

    for($i=0;$i<sizeof($copies);$i++) 
    {mb_detect_encoding($copies[$i]['title'], "UTF-8") != "UTF-8" ? : $copies[$i]['title'] = utf8_encode($copies[$i]['title']);
      mb_detect_encoding($copies[$i]['director'], "UTF-8") != "UTF-8" ? : $copies[$i]['director'] = utf8_encode($copies[$i]['director']); 
      // encodage des champs texte en utf8 si il ne le sont pas. 
    } 
    
    return $copies;
  }

  public static function get_copies_by_movies($movie_id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT c.id, c.status as status, CONCAT(UPPER(s.town), ' ', s.address) as store
                              FROM copies AS c
                              JOIN movies AS m ON c.id_movie = m.id
                              JOIN stores AS s ON c.id_store = s.id
                              WHERE m.id = :movie_id");
      // l'execution 
    $requete->bindParam(':movie_id', $movie_id);
    $requete->execute();
    $copies = $requete->fetchAll(PDO::FETCH_ASSOC); 
    
    return $copies;
  }

   public static function create_copy($post){
    global $bdd;

    $requete = $bdd->prepare("INSERT INTO copies(id_movie, id_store, id_format, status) 
                          VALUES (:id_movie, :id_store, :id_format, :status)");

    $requete->bindParam(':id_movie', $post['id_movie']);
    $requete->bindParam(':id_store', $post['id_store']);
    $requete->bindParam(':id_format', $post['id_format']);
    $requete->bindParam(':status', $post['status']);


    if($requete->execute())
      return get_movie_by_id($bdd->lastInsertId());
    else
      return "";
  }


  public static function delete_copy($id){
    global $bdd;
    $requete = $bdd->prepare("DELETE FROM copies WHERE id=:id");
    // l'execution 
    $requete->bindParam(':id', $id);
    if($requete->execute())
        return "La copie a été supprimée";
    else 
      return false;
  }



}

?>