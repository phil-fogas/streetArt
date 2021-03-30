<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./templates/attente.phtml');
require_once('./app/function.php');
require_once('./app/Database.php');

use street\Posts;

require_once('./models/Posts.php');
$posts = new posts();
$url = '?p=suggestion&e=3';

echo 'patienter je traiter la demande...<br />';

///var_dump($_FILES);

if (!empty($_FILES)&&$_FILES['photo']['error']==1){
    $_FILES['photo']=null;
  $url = '?p=suggestion&e=2';
}

if (!empty($_POST)) {

if(!empty($_POST['image'])){

    $extensions=mime_content_type($_POST['image']);
  $extension = substr($extensions, 6);
  $mine = substr($extensions,0,-4);
  $photo=uniqid() . '.' . $extension;
 $img = str_replace('data:'.$extensions.';base64,', '', $_POST['image']); // Le troisième paramètre est le nom du champ qui contient l'image dans votre formulaire sur la page précedente
     $img = str_replace(' ', '+', $img);
     $data = base64_decode($img);

 if (!$data) {
  $_POST['image']=null;
}
if (empty($mime) || strpos($mime, 'image/') !== 0) {
  $_POST['image']=null;
}


if (!in_array($extension, ['png', 'gif', 'jpeg'])) {
  $_POST['image']=null;
}

if (in_array($extension, ['png', 'gif', 'jpeg'])) {

     file_put_contents('./uploads/'.$photo, $data);

//$name = uniqid() . '.' . $extension;
$imag=array('tmp_name'=>'./uploads/'.$photo,'name'=>$photo);
$name = transfertImage($imag);

//var_dump($name);

}

}
   elseif (empty($_FILES['photo']['tmp_name'])) {
        $name = null;
    } elseif(!empty($_FILES['photo']['tmp_name']))  {

        $name = transfertPhoto($_FILES['photo']);
    }

    if (!$_POST['dateCreation']) {
        $_POST['dateCreation'] = null;
    }
    if (!$_POST['categorie']) {
        $_POST['categorie'] = 1;
    }

    if (!$_POST['latitude']||!$_POST['longitude']) {
$adresse=str_replace(' ', '+',$_POST['adresse']);
$urls='https://api-adresse.data.gouv.fr/search/?q='.$adresse.'&lat=45.75&lon=4.85';

$result = file_get_contents($urls);

$json = json_decode($result, true);

// for($i=0;$i<5;$i++){
// var_dump(preg_match("#^".$_POST['adresse']."#i", $json['features'][$i]['properties']['label']),$json['features'][$i]['properties']['name']);

// }

   if($json['features']){

    $_POST['latitude']=$json['features'][0]['geometry']['coordinates'][1];
    $_POST['longitude']=$json['features'][0]['geometry']['coordinates'][0];

    }else{
    $url = '?p=suggestion&e=2';
    }
    }

 if ($_POST['latitude']&& $name) {
    $params = ([
        'name' => nl2br(htmlspecialchars($_POST['name'])),
        'adresse' => nl2br(htmlspecialchars($_POST['adresse'])),
        'photo' => $name,
        'description' => $_POST['description'],
        'dateCreation' => $_POST['dateCreation'],
        'user' => $_POST['user_id'],
        'categorie' => $_POST['categorie'],
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude'],
    ]
    );

        //var_dump($params);
        $id = $posts->addPost($params);
       // echo $id;
        $url = '?p=suggestion&e=1';

 }

}
//var_dump($url);
echo '....fini<br />';


if ($url){
header('Location: ./index.php'.$url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();