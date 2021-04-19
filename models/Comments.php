<?php
declare(strict_types=1);

namespace street;
use Database;

class Comments extends Database
{

    public function __construct()
    {
        parent::__construct();

    }

    public function getCommentsAll(): array
    {
        //tout les commentaires
        $sql = ("SELECT comment.id,text,date_ad,id_street,name,pseudo FROM `comment`
    INNER JOIN `users` ON comment.id_users = users.id
    INNER JOIN `street` ON comment.id_street = street.id
    ORDER BY `comment`.`date_ad` DESC ;");

        return $commentsAll = $this->fetchAll($sql);
    }

    public function getComments(int $id): array
    {
        // 1 commentaire
        $sql = ("SELECT comment.id,text,date_ad,pseudo FROM `comment`
    INNER JOIN `users` ON comment.id_users = users.id
     WHERE `id_street` = :id  ORDER BY `comment`.`date_ad` DESC ;");

        return $comments = $this->fetchAll($sql, ['id' => $id]);
    }

    public function countCommentsAll(): array
    {
        //conteur de commentaire
        $sql = ("SELECT COUNT(id) AS count,id_street FROM comment GROUP BY id_street ;");
        return $counts = $this->fetchAll($sql);
    }

    public function addComments(array $params): string
    {
        //ajjoute d'un commentaire
        $sql = ("INSERT INTO `comment` (`id`, `text`, `id_users`, `id_street`, `date_ad`)
  VALUES (NULL, :text , :id_user , :street , NOW() );");

        $params = ([
            'id_user' => $params[0],
            'text' => $params[1],
            'street' => $params[2],
        ]
        );
//debug($sql,$params);
        // var_dump($sql,$params);
        return $res = $this->into($sql,$params);
    }

    public function getCommentsAllMenber(string $id): array
    {
        //tous les commentaires
        $sql = ("SELECT comment.id,text,date_ad,id_street,name,pseudo FROM `comment`
    INNER JOIN `users` ON comment.id_users = users.id
    INNER JOIN `street` ON comment.id_street = street.id
     WHERE `id_users` = :id  ORDER BY `comment`.`date_ad` DESC ;");

        return $comments = $this->fetchAll($sql, ['id' => $id]);
    }
    public function delComment(array $params): int
    {
        //supretion d'un commentaire
        $sql = ("DELETE FROM `comment` WHERE `comment`.`id` = :id ;");
        $params = ([
            'id'=> $params['id'],
        ]
        );

        $categorie = $this->delt($sql,$params );
        return $categorie;
    }

}