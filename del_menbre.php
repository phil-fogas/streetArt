<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}
require('./app/Database.php');
require('./app/function.php');

use street\Users;
require_once('./models/Users.php');
$users = new Users();

if ($_SESSION['auth']['droit']==9){

    $params = ([
        'id'=>$_GET['id'],
    ]
    );

    $users->delUser($params);
    $url='?p=menbre';
}

if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();