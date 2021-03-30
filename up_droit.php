<?php
declare(strict_types=1);
 if (session_status() == PHP_SESSION_NONE) {session_start();}
require('./app/Database.php');
require('./app/function.php');

use street\Users;
require_once('./models/Users.php');
$users = new Users();

if (!empty($_GET['id'])){
    
if ($_GET['d']=='menbre'){
    $droit=5;
}
if ($_GET['d']=='modérateur'){
    $droit=2;
}

    $params = ([
        'id'=>$_GET['id'],
        'droit'=>$droit,
        ]
        );


    $users->setUserDroit($params);


$url='?p=menbre';


}

if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
 exit();