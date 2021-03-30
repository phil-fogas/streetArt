<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use street\Comments;
use street\Users;
use street\Posts;

require_once('./app/Database.php');
require_once('./app/function.php');
require_once('./models/Posts.php');
$posts = new Posts();
require_once('./models/Comments.php');
$comments = new Comments();

require_once('./models/Users.php');
$users = new Users();



if (!empty($_SESSION['auth'])) {
    $droits =$users->droit( $_SESSION['auth']['user_id']);
}else{
    $droits =$users->droit('');
}


$streets = $posts->getPostAll($droits['valid'], $droits['statut']);

$counts = $comments->countCommentsAll();

// Affichage de la réponse au format html
require('./templates/search.phtml');
