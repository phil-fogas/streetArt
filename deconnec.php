<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}


$_SESSION = array();
session_destroy();


$url='?p=galerie';

if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();
