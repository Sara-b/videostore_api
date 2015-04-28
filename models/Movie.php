 <?php
class Movie
{

  public static function get_all_movies(){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT m.id, m.title, m.description, m.picture, CONCAT(d.first_name,' ',d.last_name) as director, c.title as category
                              FROM movies AS m
                              JOIN directors AS d ON id_director = d.id
                              JOIN categories AS c ON id_category = c.id");
      // l'execution 
    $requete->execute();
    $movies = $requete->fetchAll(PDO::FETCH_ASSOC);

    for($i=0;$i<sizeof($movies);$i++) 
    { 
      mb_detect_encoding($movies[$i]['description'], "UTF-8") != "UTF-8" ? : $movies[$i]['description'] = utf8_encode($movies[$i]['description']);
      mb_detect_encoding($movies[$i]['title'], "UTF-8") != "UTF-8" ? : $movies[$i]['title'] = utf8_encode($movies[$i]['title']);
      mb_detect_encoding($movies[$i]['director'], "UTF-8") != "UTF-8" ? : $movies[$i]['director'] = utf8_encode($movies[$i]['director']); 
      // encodage des champs texte en utf8 si il ne le sont pas. 
    } 
    
    return $movies;
  }

  public static function get_movie_by_id($id){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM movies 
                                LEFT JOIN directors ON directors.id = movies.id_director
                                WHERE movies.id=:id");
      // l'execution 
    $requete->bindParam(':id', $id);
    $requete->execute();
    $movie = $requete->fetch(PDO::FETCH_OBJ);
    
    return $movie;
  }

  public static function get_movie_by_title($title){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM movies WHERE title LIKE '%$title%'");
      // l'execution 
    $requete->execute();
    $movie = $requete->fetch(PDO::FETCH_OBJ);
    
    return $movie;
  }

  public static function get_movie_by_category($category){
    global $bdd;
    
    $requete = $bdd->prepare("SELECT * FROM movies WHERE category_id=:category");
      // l'execution 
    $requete->bindParam(':category', $category);
    $requete->execute();
    $movie = $requete->fetch(PDO::FETCH_OBJ);
    
    return $movie;
  }

  public static function create_movie($post){
    global $bdd;

    $req = $bdd->prepare("INSERT INTO movies (title, description, picture, id_category, id_director) 
                          VALUES (:title, :description, :picture, :id_category, :id_director)");

    $requete->bindParam(':title', $post['title']);
    $requete->bindParam(':description', $post['description']);
    $requete->bindParam(':picture', $post['picture']);
    $requete->bindParam(':id_category', $post['id_category']);
    $requete->bindParam(':id_director', $post['id_director']);
    $req->execute();

    return true;
  }

  public static function update_movie($post){
    global $bdd;

    $req = $bdd->prepare("UPDATE movies 
                          SET title=:title, description=:description, picture=:picture, id_category=:id_category, id_director=:id_director)
                          WHERE id=:id");

    $requete->bindParam(':title', $post['title']);
    $requete->bindParam(':description', $post['description']);
    $requete->bindParam(':picture', $post['picture']);
    $requete->bindParam(':id_category', $post['id_category']);
    $requete->bindParam(':id_director', $post['id_director']);
    $requete->bindParam(':id', $post['id']);
    $req->execute();

    return true;
  }

  public static function upload_image($movie_id){
      $target_dir = "./uploadedfiles/";
      $i=0;
      while($i<5)
      {
        if($_FILES["image"]['name'][$i]=="") break;
        else {
          $target_file = $target_dir . basename($_FILES["image"]["name"][$i]);
          $uploadOk = 1;
          $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
          // Check if image file is a actual image or fake image
          if(isset($_POST["image"])) {
              $check = getimagesize($_FILES["image"]["tmp_name"][$i]);
              if($check !== false) {
                  //echo "File is an image - " . $check["mime"] . ".";
                  $uploadOk = 1;
              } else {
                  //echo "File is not an image.";
                  $uploadOk = 0;
              }
          }
          // Check if file already exists
          if (file_exists($target_file)) {
              //echo "Sorry, file already exists.";
              $uploadOk = 0;
          }
          // Check file size
          if ($_FILES["image"]["size"][$i] > 5000000) {
              //echo "Sorry, your file is too large.";
              $uploadOk = 0;
          }
          // Allow certain file formats
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
          && $imageFileType != "gif" ) {
              //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $uploadOk = 0;
          }
          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
              //echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
          } else {
              if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {
                  //echo "The file ". basename( $_FILES["avatar"]["name"]). " has been uploaded.";

              } else {
                  //echo "Sorry, there was an error uploading your file.";
              }
          }
              $file = basename( $_FILES["image"]["name"][$i]);
              if($file!=null){
              global $bdd;

              $requete = $bdd->prepare("UPDATE movies SET image_url=:image_url WHERE id=:movie_id");
                // l'execution 
              $requete->bindParam(':movie_id', $movie_id[0][$i]);
              $requete->bindParam(':image_url', $file);

              $requete->execute();
              //echo "OK BDD"; 
            }  
        $i++;
      }
      }
    }
}
?>