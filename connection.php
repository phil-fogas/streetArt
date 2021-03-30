<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./app/Database.php');
require_once('./app/function.php');

//$db = new Database();
use street\Users;
require_once('./models/Users.php');
$users = new Users();


if (isset($_POST['pseudo'])) {

    $params = ([
        'email' => $_POST['pseudo']
    ]);


    $login = $users->getUser($params);

    if (empty($login)) {
        $url = ('?p=connection&e=2');

    } else {
        if (password_verify($_POST['password'], $login['password'])) {
            $_SESSION['auth'] = [
                'user_id' => $login['id'],
                'pseudo' => $login['pseudo'],
                'droit' => $login['droit']
            ];

            $params = ([
                'id' => $login['id']
            ]);

//var_dump($sql,$params);

        $ok=$users->setUserTime($params);
        if ($ok)
        {
            $url = ('?p=compte');
        }else {
           $url = ('?p=galerie');
        }

        } else {
            $url = ('?p=connection&e=3');
        }

    }

}
//var_dump($url);
//var_dump($_SESSION);
if ($url){
header('Location: ./index.php' . $url);
}else{
header('Location: ' .$_SERVER['HTTP_REFERER']);
}
exit();