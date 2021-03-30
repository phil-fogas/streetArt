<?php
declare(strict_types=1);
session_start();

date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

$titre = 'street art';


require_once('./app/Database.php');

//$db = new Database();

require_once('./app/function.php');

use street\Categorie;
use street\Comments;
use street\Users;
use street\Posts;
use street\Statuts;
use street\Messages;
use street\Votes;
require_once('./models/Votes.php');
$votes = new Votes();

require_once('./models/Messages.php');
$messages = new Messages();

require_once('./models/Posts.php');
$posts = new Posts();

require_once('./models/Categorie.php');
$categories = new Categorie();

require_once('./models/Comments.php');
$comments = new Comments();

require_once('./models/Statuts.php');
$statuts = new Statuts();

require_once('./models/Users.php');
$users = new Users();



/* selon les droit adminitratif
* affichage d'une partie des post
*/

if (!empty($_SESSION['auth'])) {

    $droits =$users->droit( $_SESSION['auth']['user_id']);
}else{
    $droits =$users->droit('');
}

/*
*/

$bonjour = bienvenu();

if (isset($_GET['p'])) {

    if ($_GET['p'] == 'galerie')
    {
         $categories = $categories->getCategorieAll();
        $template = 'galerie';
    }

    if ($_GET['p'] == 'detail' && isset($_GET['id']))
    {
        $_GET['id']= str_replace('street_', '', $_GET['id']);

        if (is_numeric($_GET['id'])){
            $street = $posts->getPost();
        }else {
            $street = $posts->getPostName();

        }

        $id=$street['id'];
        if (!empty($street)) {
            $comments = $comments->getComments($id);
            $vote = $votes->vote();

            $template = 'detail';
        }else{$template = '404'; }
    }

    if ($_GET['p'] == 'plan')
    {

        $template = 'plan';
    }

    if ($_GET['p'] == 'suggestion')
    {
        $categories = $categories->getCategorieAll();
        $template = 'suggestion';
    }

    if ($_GET['p'] == 'contact')
    {

        $template = 'contact';
    }
    if ($_GET['p'] == 'addCompte')
    {

        $template = 'addCompte';
    }
    if ($_GET['p'] == 'connection')
    {

        $template = 'connection';
    }
    if ($_GET['p'] == 'oublier')
    {

        $template = 'oublier';
    }
    if ($_GET['p'] == 'propos')
    {
        $count=$posts->countPostAll();
        $template = 'propos';
    }
    if ($_GET['p'] == 'jeux')
    {

    // $images=$posts->getPostAllrandom('5', '2',1 );
    // file_put_contents('./images.json', json_encode($images));

        $stript='ping.js';
        $template = 'jeux';
    }
    if ($_GET['p'] == 'message'&& $droits['droit'] == 9 ) {
    $messages=$messages->getMessageAll();
        $template = 'message';
    }
    if ($_GET['p'] == 'menbre'&& $droits['droit'] == 9 ) {

        $users = $users->getMenberAll();

        $template = 'menbre';
    }
    if ($_GET['p'] == 'compte' && !empty($_SESSION['auth']) )
    {

        $template = 'compte';
    }
    if ($_GET['p'] == 'categorie'&& $droits['droit'] == 9 )
    {
        $categories = $categories->getCategorieAll();
        $template = 'categorie';
    }
    if ($_GET['p'] == 'comment')
    {
        $comment = $comments->getCommentsAllMenber($_SESSION['auth']['user_id']);

        if ($_SESSION['auth']['droit'] == 9 || $_SESSION['auth']['droit'] == 5)
        {
            $commentsAll = ($comments->getCommentsAll() );
        }

        $template = 'comment';
    }

    if ($_GET['p'] == 'street' && !empty($_SESSION['auth']) )
    {
        if ($_SESSION['auth']['droit'] == 2 && $droits['droit'] == 2){
        $streets = $posts->getPostAllMenber( $_SESSION['auth']['user_id']);
}
        if ($_SESSION['auth']['droit'] == 9 && $droits['droit'] == 9 || $_SESSION['auth']['droit'] == 5 && $droits['droit'] == 5) {
            $streetAll = $posts->getPostAllMenbers();
            //$statuts = $statuts->getStatutAll();

        }
        $template = 'street';
    }

    if ($_GET['p'] == 'modif' && isset($_GET['id']) && !empty($_SESSION['auth']))
    {

          $street = $posts->getPost();

    if ($_SESSION['auth']['droit'] == 9 && $droits['droit'] == 9 || $_SESSION['auth']['droit'] == 5 && $droits['droit'] == 5
    || $_SESSION['auth']['pseudo']==$street['pseudo']) {
        $categories = $categories->getCategorieAll();
        $statuts = $statuts->getStatutAll();
         $template = 'modif';
      }

    }



} else {

    $streets = $posts->getPostAllrandom($droits['valid'], $droits['statut'],3);

    $template = 'home';
}

if (empty($template) || !file_exists('./templates/' . $template . '.phtml'))
{
    $template = '404';
}


if (isset($template) )
{
    $titre = ucfirst($template.' streetArt');
    $descrition=ucfirst($template.' découverte street Art référencé par des internaute passionnee dans leur ville.');
}

require 'templates/layout.phtml';
