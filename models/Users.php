<?php
declare(strict_types=1);

namespace street;
use Database;
/**
 * Class Users
 * @package street
 */
class Users extends Database
{


    public function __construct()
    {
    parent::__construct();


    }

    public function droit( string $droi): array
    {
        if (!$droi){
            $sql = 'SELECT valid,statut,id FROM `droit` WHERE droit.`id` = 1 ;';

        }else{
            $sql = 'SELECT valid,statut,droit,droit.id  FROM `droit` INNER JOIN `users` ON droit.id = users.droit WHERE users.`id` = ' . $droi . ' ;';
        }

        $droit = $this->fetch($sql);
        $droits = ['droit'=>$droit['id'],'valid' => ($droit['valid']), 'statut' => $droit['statut']];

        return $droits;
    }

    public function getMenberAll(): array
    {
        $sql = ("SELECT users.id,pseudo,droit,created_at,dateVisi,name FROM `users` INNER JOIN `droit` ON droit.id= `users`.droit ;");

        $menbers =$this->fetchAll($sql);
        return $menbers;
    }

    public function getUser(array $params): array
    {
        //var_dump($params);
        $sql = ("SELECT id,pseudo,password,email,droit FROM `users` WHERE email LIKE :email OR pseudo like :email ;");

        $params = ([
            'email' => $params['email'],
        ]);

         return $login = $this->fetch($sql, $params);
    }
     public function getUserOublier(array $params): array
    {
        //var_dump($params);
        $sql = ("SELECT id,pseudo,password,email,droit FROM `users` WHERE email LIKE :email OR pseudo like :pseudo ;");

        $params = ([
            'email' => $params['email'],
            'pseudo' => $params['pseudo'],
        ]);

         return $login = $this->fetch($sql, $params);
    }
    public function setUserTime(array $params): int
    {
        $sql = ("UPDATE `users` SET `dateVisi` = NOW() WHERE `users`.`id` = :id ;");
        $params = ([
            'id' => $params['id']
        ]);

        return $ok = $this->update($sql, $params);
    }
    public function delUser(array $params): int
    {
        $sql = ("DELETE FROM `users` WHERE `users`.`id` = :id ;");
        $params = ([
            'id'=> $params['id'],
        ]
        );

        $user = $this->delt($sql,$params );
        return $user;
    }

    public function addUser( array $params): string
    {

              $sql = ("INSERT INTO `users`
  (`id`, `pseudo`, `email`, `password`, `droit`, `created_at`)
  VALUES (NULL, :pseudo, :email, :password, :droit , NOW() );");

        $params = ([
            'pseudo'=>$params['pseudo'],
            'email'=>$params['email'],
            'password'=>password_hash($params['password'],PASSWORD_BCRYPT),
            'droit'=>'2',
        ]
        );
//debug($sql,$params);
        // var_dump($sql,$params);
        return $res = $this->into($sql, $params);
    }

    public function upUser( array $params): string
    {

              $sql = ("UPDATE `users` SET `password` = :password WHERE `users`.`id` = :id ;");

        $params = ([
            'id'=>$params['id'],
            'password'=>password_hash($params['password'],PASSWORD_BCRYPT),
        ]
        );

        return $res = $this->update($sql, $params);
    }
     public function setUserDroit(array $params): int
    {
        $sql = ("UPDATE `users` SET `droit` = :droit WHERE `users`.`id` = :id_user;");
        $params = ([
            'id_user' => $params['id'],
            'droit' => $params['droit'],
        ]);

        return $ok = $this->update($sql, $params);
    }
}