<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}

require './app/Database.php';
require './app/function.php';
use street\Messages;

require_once('./models/Messages.php');
$messages = new Messages();



if ($_SESSION['auth']['droit']==9) {

    $params = ([
        'id' => $_GET['id'],
    ]
    );

    $number = $messages->delMessage($params);

    echo $number;
}
$url='?p=message';

if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);    
}

exit();
