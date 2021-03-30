<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once('./app/function.php');
require_once('./app/Database.php');


use street\Comments;

require_once('./models/Comments.php');
$comments = new Comments();

if (!empty($_POST)) {
    $params = ([
        nl2br(htmlspecialchars($_POST['user_id'])),
        nl2br(htmlspecialchars($_POST['comment'])),
        $_POST['street'],
    ]
    );
    $res = $comments->addComments($params);
//debug($res);
    //if(isset($res)){$erreur=1;}else{$erreur=0;}
    // .'&ereur='.$erreur
    $url = '?p=detail&id=' . $_POST['street'];
}


if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();