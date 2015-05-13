<?php  header("Access-Control-Allow-Origin: *");
  //require composer autoload (load all my libraries)
  require 'vendor/autoload.php';
  require 'connection_bdd.php';
  //require my models
  require 'models/Movie.php';
  require 'models/Customer.php';
  require 'models/Store.php';
  require 'models/Rental.php';
  require 'models/Administrator.php';
  require 'models/category.php';

  // Slim initialisation
  $app = new \Slim\Slim();

  // hook before.router, now $app is accessible in my views
  $app->hook('slim.before.router', function () use ($app) {
    $app->view()->setData('app', $app);
  });


  //ROUTES

  // root
  $app->get('/', function(){
  	echo "Vous etes à la racine";
   	})->name('root'); // named route so I can use with "urlFor" method
  

  //VIDEOS
  //GET all videos 
  $app->get('/videos', function () use ($app) {  
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode( Movie::get_all_movies('movies'), JSON_UNESCAPED_UNICODE);
  });

  //GET video by id
  $app->get('/videos/:id', function($id) use($app) {
    $movie = Movie::get_movie_by_id($id); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($movie, JSON_UNESCAPED_UNICODE);
	});

  //GET video by title
  $app->get('/videos/title/:title', function($title) use($app){
    $movie = Movie::get_movie_by_title($title);
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($movie, JSON_UNESCAPED_UNICODE);
  });

  //GET videos by category
  $app->get('/videos/category/:category', function($category) use($app){
    $movie = Movie::get_movie_by_category($category);
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($movie, JSON_UNESCAPED_UNICODE);
  });  

  //DELETE video
  $app->post('/videos/:id', function($id) use($app){
    $result = Movie::delete_movie($id);
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }); 

    //UPDATE video
  $app->put('/videos/:id/update', function($id) use($app){
    $movie = Movie::update_movie($_REQUEST, $id);
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($movie, JSON_UNESCAPED_UNICODE);
  });  

  $app->post('/videos', function() use($app){
    $movie = Movie::create_movie($_REQUEST);
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($movie, JSON_UNESCAPED_UNICODE);
  });  



  //CATEGORIES
  //GET all categories 
  $app->get('/categories', function () use ($app) {  
    $categories = Category::get_all_categories(); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($categories, JSON_UNESCAPED_UNICODE);
  });


  //CUSTOMERS
  //GET all customers 
  $app->get('/users', function () use ($app) {  
    $users = Customer::get_all_users(); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($users, JSON_UNESCAPED_UNICODE);
  });

  //Get User by id
   $app->get('/users/:id', function ($id) use ($app) {  
    $user = Customer::get_user_by_id($id); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($user, JSON_UNESCAPED_UNICODE);
  });

  //Connexion
   $app->post('/users/connexion', function () use ($app) {  
    $user = Customer::connexion($_POST['mail'],$_POST['password']); 
    $app->response("connexion reussie")->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($user, JSON_UNESCAPED_UNICODE);
  });
   //Connexion
   $app->post('/admin/connexion', function () use ($app) {  
    $user = Administrator::connexion($_POST['mail'],$_POST['password']); 
    if($user!="false"){
      $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
      echo json_encode($user, JSON_UNESCAPED_UNICODE);
    }
    else
      echo $user;
  });

   //STORES
  //GET all stores 
  $app->get('/magasins', function () use ($app) {  
    $stores = Store::get_all_store(); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($stores, JSON_UNESCAPED_UNICODE);
  });

  //Get store by id
   $app->get('/magasins/:id', function ($id) use ($app) {  
    $store = Store::get_store_by_id($id); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($store, JSON_UNESCAPED_UNICODE);
  });



   //ADMINISTRATOR
  //GET all admins 
  $app->get('/employes', function () use ($app) {  
    $administrators = Administrator::get_all_administrators(); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($administrators, JSON_UNESCAPED_UNICODE);
  });

  //Get admin by id
   $app->get('/employes/:id', function ($id) use ($app) {  
    $administrator = Administrator::get_administrator_by_id($id); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($administrator, JSON_UNESCAPED_UNICODE);
  });

   //Get admins by store
   $app->get('/employes/store/:id', function ($store_id) use ($app) {  
    $administrators = Administrator::get_administrators_by_store($store_id); 
    $app->response()->header('Content-Type: application/json; Charset="UTF-8"');
    echo json_encode($administrators, JSON_UNESCAPED_UNICODE);
  });


  $app->run();
?>