<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}
require './app/Database.php';
require './app/function.php';
use street\Votes;
require_once('./models/Votes.php');
$votes = new Votes();


//$valid=null;
$val=1;


if ($_SESSION['auth']['droit']==5||$_SESSION['auth']['droit']==9){
    $val=5;
}

if ($_GET['vote']=='oui'){
    $valid=+$val;
}
if ($_GET['vote']=='non'){
    $valid=-$val;
}


$params = ([
    'user_id'=>$_SESSION['auth']['user_id'],
    'vote'=>$_GET['vote'],
    'valid'=>$valid,
    'id'=>$_GET['id']
]
);

$votes->addVote($params);

$url = '?p=galerie';
if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: '.$_SERVER['HTTP_REFERER']);
}
 exit();

