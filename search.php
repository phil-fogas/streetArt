<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use street\Comments;
use street\Users;
use street\Posts;

// resulta des recherche en ajax ou manuel
$root = '.';
require_once($root.'/app/Database.php');
require_once($root.'/app/function.php');
require_once($root.'/models/Posts.php');
$posts = new Posts();
require_once($root.'/models/Comments.php');
$comments = new Comments();

require_once($root.'/models/Users.php');
$users = new Users();

// verrification des droit
if (!empty($_SESSION['auth'])) {
    $droits =$users->droit( $_SESSION['auth']['user_id']);
}else{
    $droits =$users->droit('');
}
// recuperation des fiches
$streets = $posts->getPostAll($droits['valid'], $droits['statut']);

$counts = $comments->countCommentsAll();

// Affichage de la réponse au format html
require($root.'/templates/search.phtml');
