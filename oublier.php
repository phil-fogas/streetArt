<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {session_start();}
require('./app/Database.php');
require('./app/function.php');

use street\Users;
require_once('./models/Users.php');
$users = new Users();

if (isset($_POST['pseudo'])){


    $params = ([
        'email'=>$_POST['email'],
        'pseudo'=>$_POST['pseudo'],
    ]);

    $user=$users->getUserOublier($params);
    // var_dump($user);
    if (empty($user)){

        $params = ([
            'id'=>$user['id'],
            'password'=>$_POST['password'],
            ]
        );

        $id=$users->upUser($params);
        // var_dump($id);
        if ($id) {
            $_SESSION['auth']=[
                'user_id'=>$user['id'],
                'pseudo'=>$user['pseudo'],
                'email'=>$user['email'],
                'droit'=>$user['droit'],
            ];
            $url='?p=compte';
            $_SESSION['insc']=true;
        }
    }
    $url='?p=galerie';
    $_SESSION['insc']=false;
}
else {
    $url='';
    $_SESSION['insc']=false;
}


if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();