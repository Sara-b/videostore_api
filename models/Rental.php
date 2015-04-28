<?php 

/**
* 
*/
class Rental
{
	
	public static function get_all_rental(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM rentals");
      // l'execution 
    $requete->execute();
    $rentals = $requete->fetchAll(PDO::FETCH_OBJ);
    
    return $rentals;
  }

  public static function get_rental_by_id($id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM rentals WHERE id=:id");
      // l'execution 
    $requete->bindParam(':id', $id);
    $requete->execute();
    $rental = $requete->fetch(PDO::FETCH_OBJ);
    
    return $rental;
  }

  public static function get_rental_by_user($user_id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM rentals WHERE id_customer=:user_id");
      // l'execution 
    $requete->bindParam(':user_id', $user_id);
    $requete->execute();
    $rentals = $requete->fetch(PDO::FETCH_OBJ);
    
    return $rentals;
  }

  public static function get_rental_by_copy($copy_id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM rentals WHERE id_copy=:copy_id");
      // l'execution 
    $requete->bindParam(':copy_id', $copy_id);
    $requete->execute();
    $rentals = $requete->fetch(PDO::FETCH_OBJ);
    
    return $rentals;
  }

  public static function create_rental($post){
    global $bdd;

    $req = $bdd->prepare("INSERT INTO rentals (id_customer, id_copy, leaving_date, return_date) 
                          VALUES (:id_customer, :id_copy, :leaving_date, :return_date)");

    $requete->bindParam(':id_customer', $post['id_customer']);
    $requete->bindParam(':id_copy', $post['id_copy']);
    $requete->bindParam(':leaving_date', $post['leaving_date']);
    $requete->bindParam(':return_date', $post['return_date']);
    $req->execute();

    return true;
  }

  static function update_rental($param){
    global $bdd;

    $requete = $bdd->prepare("UPDATE rentals
                SET id_customer=:id_customer,id_copy=:id_copy,leaving_date=:leaving_date,return_date=:return_date 
                WHERE id=:id");
    // l'execution 
    $requete->bindParam(':id_customer', $param['id_customer']);
    $requete->bindParam(':id_copy', $param['id_copy']);
    $requete->bindParam(':leaving_date', $param['leaving_date']);
    $requete->bindParam(':return_date', $param['return_date']);
    $requete->bindParam(':id', $param['id']);
    $requete->execute();
  }

  static function delete_rental($param){
    global $bdd;

    $requete = $bdd->prepare("DELETE FROM rentals
                WHERE id=:id");
    // l'execution 
    $requete->bindParam(':id', $param['id']);
    $requete->execute();
  }
}

?>