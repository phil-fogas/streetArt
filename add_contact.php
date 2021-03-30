<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./app/Database.php');
use street\Messages;
require_once('./models/Messages.php');
$messages = new Messages();

$erreur = 0;
$sujet = addslashes($_POST['sujet']);
$mail = addslashes($_POST['email']);
$message = addslashes($_POST['message']);



if (isset($_POST['email'])){
$envoi = 'graph@la-passion.fr';
$mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
//var_dump($_POST);

$mail = trim(preg_replace("/[\r\n]+/", "", $mail));
$passage_ligne = "\r\n";
$header = '';
$header .= "MIME-Version: 1.0" . $passage_ligne;

$header .= "Subject: '.$sujet.' " . $passage_ligne;
$header .= "Date: " . date('r') . $passage_ligne;
$header .= "From: $mail " . $passage_ligne;
$message = (wordwrap($message, 70, $passage_ligne));
$message = htmlentities(preg_replace('/[\r\n]+/', '', $message), ENT_QUOTES, 'UTF-8');


$message = $passage_ligne . $message . $passage_ligne;

$message = str_replace('\n.', '\n..', $message);
}

//var_dump($_POST);
if (!empty($_POST) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $erreur = 3;

    $verif_envoi_mail = @mail($envoi, $sujet, $message, $header);
    if ($verif_envoi_mail === FALSE) {
        $erreur = 2;

    } else {
        $erreur = 1;

    }

}

 if (!$_POST['email']&&$_SESSION['auth']['pseudo'])
 {
    $_POST['email']=$_SESSION['auth']['pseudo'];
     $erreur = 1;
 }

if ($erreur == 1)
{
    $params = ([
        'email' => $_POST['email'],
        'message' => $_POST['message'],
        'sujet' => $_POST['sujet'],
    ]
    );


    $messages->addMessage($params);

}
var_dump($ereur);

if ($erreur){
header('Location: ./index.php?p=contact&e=' . $erreur . '');
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}

exit();
