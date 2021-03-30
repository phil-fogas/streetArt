<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}
require('./app/Database.php');
require('./app/function.php');

use street\Categorie;
require_once('./models/Categorie.php');
$categories = new Categorie();


if ($_SESSION['auth']['droit']==9){

    $params = ([
        'id'=>$_POST['categorieDel'],
    ]
    );

    $Categorie->delCategorie($params);
    $url='?p=categorie';
}
if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);    
}
exit();
