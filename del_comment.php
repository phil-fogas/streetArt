<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require './app/Database.php';
require './app/function.php';
use street\Comments;
require_once('./models/Comments.php');
$comments = new Comments();

$url = '';
if ($_SESSION['auth']) {



    $params = ([
        'id' => $_GET['id'],
    ]
    );
//var_dump($sql,$params);

    $number = $comments->delComment($params);

    echo $number;
}

if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);    
}

exit();
