<?php
declare(strict_types=1);


require_once('./app/Database.php');
use street\Posts;
require_once('./models/Posts.php');
$posts = new Posts();

//image aleatoire pour fond de jeu en Js
    $images=$posts->getPostAllrandom('5', '2',1 );


header('Content-type:application/json;charset=utf-8');
echo json_encode($images);