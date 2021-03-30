<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}
require('./app/Database.php');
require('./app/function.php');

use street\Users;
require_once('./models/Users.php');
$users = new Users();

if (isset($_POST)){
$_POST['email']=nl2br(htmlspecialchars($_POST['email']));
 $testmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

if($testmail == TRUE)
   {
list($compte, $domaine) = explode("@",$_POST['email']);
    if(checkdnsrr($domaine,"MX"))
    {
     $_POST['email']=$_POST['email'];


    }else{
        $_POST['email']=null;
        $url='?p=galerie';

    }
}

if (!empty($_POST['email'])){
    $params = ([
        'email'=>$_POST['email'],

    ]);

    $user=$users->getUser($params);
    // var_dump($user);
    if (empty($user)){

        $params = ([
            'pseudo'=>nl2br(htmlspecialchars($_POST['pseudo'])),
            'email'=>$_POST['email'],
            'password'=>$_POST['password'],
            ]
        );

        //$id=$users->addUser($params);
        // var_dump($id);
        if (!empty($id)) {
            $_SESSION['auth']=[
                'user_id'=>$id,
                'pseudo'=>nl2br(htmlspecialchars($_POST['pseudo'])),
                'email'=>nl2br(htmlspecialchars($_POST['email'])),
                'droit'=>'2',
            ];
            $url='?p=compte';

        }
    }
    $url='?p=galerie';
}
}


if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();
