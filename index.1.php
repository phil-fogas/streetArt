<?php
declare(strict_types=1);
session_start();

date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");

$titre='street art';

require('./library/Database.php');
require('./library/function.php');

$db = new Database();

$page='accueil';
 $bonjour=bienvenu();

if (empty($_GET['p'])){
 $page='accueil';
 $bonjour=bienvenu();

}else{

if($_GET['p']==='galerie'){

 $valid=5;
 $etat=1;
if (!empty($_SESSION)){
if ($_SESSION['auth']['droit']==9){
 $valid=0;
 $etat=0;
}

if ($_SESSION['auth']['droit']==5){
 $valid=1;
 $etat=1;
}
}

$sql=("SELECT
street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,categorie.name AS categorie,statut
FROM `street`
INNER JOIN `users` ON street.id_user = users.id
INNER JOIN `categorie` ON categorie.id = street.categorie
INNER JOIN `etat` ON street.etat = etat.id
WHERE street.valid >= :valid AND street.etat >= :etat
;");
$streets = $db->fetchAll($sql,['valid'=>$valid,'etat'=>$etat]);

//compte les commentaire
$sql=("SELECT COUNT(*) AS count,id_street FROM comment GROUP BY id_street;");
$counts= $db->fetchAll($sql);

$sql=("SELECT id,name FROM `categorie`;");
$categories = $db->fetchAll($sql);


 $page='galerie';
}

if($_GET['p']==='detailStreet' && $_GET['street']){

$sql=("SELECT street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,categorie.name AS categorie,statut
FROM `street`
INNER JOIN `users` ON street.id_user = users.id
INNER JOIN `categorie` ON categorie.id = street.categorie
INNER JOIN `etat` ON street.etat = etat.id
WHERE street.id =:id ;");
$street = $db->fetch($sql,['id'=>$_GET['street']]);

//verifi si deja voter
$sql=("SELECT chose FROM `validation` WHERE `id_user` = :id_user AND `id_street` = :id ;");

if (!empty($_SESSION)){
$chose = $db->fetch($sql,['id_user'=>$_SESSION['auth']['user_id'],'id'=>$_GET['street']]);
}

//les commnetaires
$sql=("SELECT comment.id,text,date_ad,pseudo FROM `comment`
INNER JOIN `users` ON comment.id_users = users.id
 WHERE `id_street` = :id ;");
//
$comments = $db->fetchAll($sql,['id'=>$_GET['street']]);

 $page='detailStreet';
}

if($_GET['p']==='modifStreet'){

$sql=("SELECT street.id,name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,etat,categorie
FROM `street`
INNER JOIN `users` ON street.id_user = users.id WHERE street.id =:id;");
$street = $db->fetch($sql,['id'=>$_GET['street']]);

 $sql=("SELECT id,name FROM `categorie`;");

$categories = $db->fetchAll($sql);
 $page='modifStreet';
}


if($_GET['p']==='categorie'){


 $sql=("SELECT id,name FROM `categorie`;");

$categories = $db->fetchAll($sql);
 $page='categorie';
}

if($_GET['p']==='message'){


 $sql=("SELECT * FROM `mail`;");

$emails = $db->fetchAll($sql);
 $page='message';
}
if($_GET['p']==='compte'){
 $bonjour=bienvenu();
 $page='compte';
}

if($_GET['p']==='comment'){
 if ($_SESSION['auth']['droit']==9 || $_SESSION['auth']['droit']==5) {
$sql=("SELECT comment.id,text,date_ad,id_street,street.name,pseudo,users.id
FROM `comment`
INNER JOIN `street` ON comment.id_street = street.id
INNER JOIN `users` ON comment.id_users = users.id
ORDER BY `users`.`droit` ASC
 ;");
  $params = [];
 }else{
 $sql=("SELECT comment.id,text,date_ad,id_street,street.name,pseudo,users.id
FROM `comment`
INNER JOIN `street` ON comment.id_street = street.id
INNER JOIN `users` ON comment.id_users = users.id
WHERE `id_users` = :id
ORDER BY `users`.`droit` ASC
 ;");
 $params = ([
        'id'=>$_SESSION['auth']['user_id']
        ]);
 }
//
$comments = $db->fetchAll($sql, $params);
 $page='comment';
}

if($_GET['p']==='street'){
if ($_SESSION['auth']['droit']==9 || $_SESSION['auth']['droit']==5) {
$sql=("SELECT street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,categorie.name AS categorie
FROM `street`
INNER JOIN `users` ON street.id_user = users.id
INNER JOIN `categorie` ON categorie.id = street.categorie
 ;");
   $params = [];
 }else{
 $sql=("SELECT street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,categorie.name AS categorie
FROM `street`
INNER JOIN `users` ON street.id_user = users.id
INNER JOIN `categorie` ON categorie.id = street.categorie
WHERE `id_users` = :id
 ;");
 $params = ([
        'id'=>$_SESSION['auth']['user_id']
        ]);
 }
$streets = $db->fetchAll($sql);
 $page='street';
}

if($_GET['p']==='plan'){
 $page='plan';
}

if($_GET['p']==='suggestion'){
 $sql=("SELECT id,name FROM `categorie`;");

$categories = $db->fetchAll($sql);

 $page='suggestion';
}

if($_GET['p']==='menbre'){
 $sql=("SELECT users.id,pseudo,droit,dateVisi,created_at,droit.name
 FROM `users`
 INNER JOIN `droit` ON `users`.droit = `droit`.id;");

$menbres = $db->fetchAll($sql);

 $page='menbre';
}
if($_GET['p']==='perso'){
 $page='perso';
}

if($_GET['p']==='contact'){
 $page='contact';
}

if($_GET['p']==='creationCompte'){
 $page='creationCompte';
}

}

//require('./model/index.php');
require('./template/index.phtml');