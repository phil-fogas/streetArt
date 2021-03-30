<?php
declare(strict_types=1);
 if (session_status() == PHP_SESSION_NONE) {session_start();}
 require './app/Database.php';
require './app/function.php';
use street\Posts;
require_once('./models/Posts.php');
$posts = new Posts();




    $params = ([
        'id'=>$_GET['id']
        ]
        );
 //var_dump($sql,$params);
$posts->setPostArchiv($params);


//var_dump($sql,$params);
 $url='?p=categorie';
if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}

exit();
