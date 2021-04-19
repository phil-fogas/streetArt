<?php
declare(strict_types=1);

namespace street;
use Database;

class Votes extends Database
{
    public function __construct()
    {
        parent::__construct();

    }


    public function vote(): array
    {
        // verification sur le vote du menbre
        $sql = ("SELECT chose FROM `validation` WHERE `id_user` = :id_user AND `id_street` = :id ;");

        if (!empty($_SESSION)) {
            return $vote = $this->fetch($sql, ['id_user' => $_SESSION['auth']['user_id'], 'id' => $_GET['id']]);
        }
        return $vote=[];
    }

    public function addVote(array $params): string
    {
        // ajout vote
        $sql = ("UPDATE `street` SET `valid` = `valid`+:valid WHERE `street`.`id` = :id ;");

        $param = ([
            'valid'=>$params['valid'],
            'id'=>$params['id']
        ]
        );

        $this->update($sql, $param);

        $sql = ("INSERT INTO `validation` (`id`, `id_user`, `id_street`, `chose`) VALUES (NULL, :user_id, :id, :vote );");

        $params = ([
            'user_id'=>$params['user_id'],
            'id'=>$params['id'],
            'vote'=>$params['vote'],
        ]
        );


        return $res = $this->into($sql, $params);
    }
}
