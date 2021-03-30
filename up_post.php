<?php
declare(strict_types=1);
 if (session_status() == PHP_SESSION_NONE) {session_start();}
require('./app/Database.php');
require('./app/function.php');

use street\Posts;
require_once('./models/Posts.php');
$posts = new Posts();

if (!empty($_POST)){
 if (!$_POST['dateCreation']){$_POST['dateCreation']=null;}


    $params = ([
        'name'=>$_POST['name'],
        'adresse'=>$_POST['adresse'],
        'description'=>$_POST['description'],
        'dateCreation'=>$_POST['dateCreation'],
        'categorie'=>$_POST['categorie'],
        'statut'=>$_POST['statut'],
        'valid'=>$_POST['valid'],
        'id'=>$_GET['id']
        ]
        );

var_dump($_POST,$params);
    $posts->setPost($params);


$url='?p=galerie';


}
if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
 exit();
