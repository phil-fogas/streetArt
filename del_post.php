<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once('./app/function.php');
require_once('./app/Database.php');


use street\Posts;

require_once('./models/Posts.php');
$posts = new posts();
if ($_SESSION['auth']['droit'] == 9) {


    $params = ([
        'id' => $_GET['id'],
    ]
    );
//var_dump($sql,$params);

    $number = $posts->delPost($params);

    echo $number;
}
$url = '?p=street';


if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}

exit();

