<?php
declare(strict_types=1);

namespace street;
use Database;


class Messages extends Database
{

    public function __construct()
    {
        parent::__construct();

    }
    public function getMessageAll(): array
    {
        //liste des messages
        $sql = ("SELECT id,email,sujet,message,date FROM `message` ORDER BY `message`.`date` DESC ;");

        $message = $this->fetchAll($sql);
        return $message;
    }

    public function delMessage(array $params): int
    {
        //supretion message
        $sql = ("DELETE FROM `message` WHERE `id` = :id ;");
        $params = ([
            'id'=> $params['id'],
        ]
        );

        $message = $this->delt($sql,$params );
        return $message;
    }

    public function addMessage( array $params): string
    {
    // ajoute de nouveau message
    $sql = ("INSERT INTO `message` (`id`, `email`, `sujet`, `message`, `date`)
            VALUES (NULL, :email, :sujet, :message , NOW() );");

    $params = ([
        'email' => $params['email'],
        'message' => $params['message'],
        'sujet' => $params['sujet'],
        ]
        );
//debug($sql,$params);
        // var_dump($sql,$params);
        return $res = $this->into($sql, $params);
    }
}