<?php
declare(strict_types=1);

namespace street;
use Database;

 class Categorie extends Database
{


     public function __construct()
     {
         parent::__construct();

     }

    public function getCategorieAll(): array
    {
        //liste de tout les  categorie
        $sql = ("SELECT id,name FROM `categorie` ORDER BY `categorie`.`name` ASC ;");

        $categories = $this->fetchAll($sql);
        return $categories;
    }
     public function setCategorie(array $params): string
     {
         //ajout de categorie
         $sql = ("INSERT INTO `categorie` (`id`, `name`) VALUES (NULL, :name ) ;");
         $params = ([
             'name'=> $params['name'],
         ]
         );

         $categorie = $this->into($sql,$params );
         return $categorie;
     }

     public function delCategorie(array $params): int
     {
         //supretion  de une categorie
         $sql = ("DELETE FROM `categorie` WHERE `categorie`.`id` = :id ;");
         $params = ([
             'id'=> $params['id'],
         ]
         );

         $categorie = $this->delt($sql,$params );
         return $categorie;
     }
}