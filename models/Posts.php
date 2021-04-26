<?php
declare(strict_types=1);

namespace street;
use Database;

class Posts extends Database
{
    public function __construct()
    {
        parent::__construct();

    }

    public function getPost(string $id): array
    {
        // 1 fiche par id
        $sql = ("SELECT street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,valid,categorie.name AS categorie,statut.statut
    FROM `street`
    INNER JOIN `users` ON street.id_user = users.id
    INNER JOIN `categorie` ON categorie.id = street.categorie
    INNER JOIN `statut` ON street.statut = statut.id
    WHERE street.id = :id ;");
        return $this->fetch($sql, ['id' => $id ]);

    }

    public function getPostName(string $id): array
    {// 1 fiche par name
        $sql = ("SELECT street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,valid,categorie.name AS categorie,statut.statut
    FROM `street`
    INNER JOIN `users` ON street.id_user = users.id
    INNER JOIN `categorie` ON categorie.id = street.categorie
    INNER JOIN `statut` ON street.statut = statut.id
    WHERE `street`.`name` LIKE :id ;");

        return $this->fetch($sql, ['id' => $id ] );
    }

    public function getPostAll( string $valid, string $statut): array
    {
        //recheche des fiches selon plusieur critere
         $sql = "SELECT street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,valid,categorie.name AS categorie,statut.statut,latitude,longitude ";

   if (!empty($_GET['km'])) {
       $latitude=$_GET['latitude'];
       $longitude=$_GET['longitude'];

 //$formule=" get_distance_metres('$latitude, $longitude, latitude, longitude) ";
        if (!$latitude||!$longitude) {

    $adresse=str_replace(' ', '+',$_GET['adresse']);
    $url='https://api-adresse.data.gouv.fr/search/?q='.$adresse.'';

    $result = file_get_contents($url);

    $json = json_decode($result, true);

    $latitude=$json['features'][0]['geometry']['coordinates'][1];
    $longitude=$json['features'][0]['geometry']['coordinates'][0];

    }
    $formule="(6366 * acos(cos(radians($latitude)) * cos(radians(`latitude`)) * cos(radians(`longitude`) - radians($longitude)) + sin(radians($latitude)) * sin(radians(`latitude`))))";
       $sql .= " ,".$formule." AS dist ";
//var_dump($formule);
        }

    $sql .= " FROM `street`
    INNER JOIN `users` ON street.id_user = users.id
    INNER JOIN `categorie` ON categorie.id = street.categorie
    INNER JOIN `statut` ON street.statut = statut.id
    WHERE street.valid >= :valid AND street.statut >= :statut
    ";

        $params = ([
            'valid' => $valid,
            'statut' => $statut,
        ]);

        if (!empty($_GET['categorie'])) {
            $sql .= " AND categorie = :categorie ";
            $params = (['categorie' => $_GET['categorie']]) + $params;
        }
        if (!empty($_GET['rue'])) {
            $sql .= " AND `adresse` LIKE :rue ";
            $params = (['rue' => '%' . $_GET['rue'] . '%']) + $params;
        }
        if (!empty($formule)){
            //$sql .= " AND $formule<=".$_GET['km']." ORDER by dist ASC";
            $sql .= " HAVING dist <=".$_GET['km']." ";
        $sql .= " ORDER BY dist ASC ;";
        }

        if (empty($formule)){

            $sql .= " ORDER BY `street`.`dateFiche` ASC ;";
        }

//var_dump($sql, $params);
        return $this->fetchAll($sql, $params);
    }

    public function getPostAllrandom( string $valid, string $statut,int $max=3 ): array
    {
        // fiche au hasard
         $sql = "SELECT
    street.id,street.name,photo,statut.statut
     FROM `street`
    INNER JOIN `users` ON street.id_user = users.id
    INNER JOIN `statut` ON street.statut = statut.id
    WHERE street.valid >= :valid AND street.statut >= :statut
    ORDER BY RAND() LIMIT $max ;";

        $params = ([
            'valid' => $valid,
            'statut' => $statut,

        ]);

        return $this->fetchAll($sql, $params);
    }

    public function getPostAllMenber(string $id): array
    {
    // liste de toute les fiches pour 1 user
        $sql = ("SELECT
    street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,categorie.name AS categorie,statut.statut
    FROM `street`
    INNER JOIN `users` ON street.id_user = users.id
    INNER JOIN `categorie` ON categorie.id = street.categorie
    INNER JOIN `statut` ON street.statut = statut.id
    WHERE users.id = :id ORDER BY `street`.`dateFiche` DESC
    ;");

        $params = ([
            'id' => $id,
        ]);

        return $this->fetchAll($sql, $params);
    }

    public function getPostAllMenbers(): array
    {
    // liste de toute les fiches de tous les user
        $sql = ("SELECT
    street.id,street.name,adresse,photo,description,dateCreation,dateFiche,users.pseudo,categorie.name AS categorie,statut.statut
    FROM `street`
    INNER JOIN `users` ON street.id_user = users.id
    INNER JOIN `categorie` ON categorie.id = street.categorie
    INNER JOIN `statut` ON street.statut = statut.id
    ORDER BY `street`.`dateFiche` DESC
    ;");


        return $this->fetchAll($sql);
    }

    public function countPostAll(): array
    {
        // conteur de fiches, user, fiche valide
        $sql = ("SELECT ( SELECT COUNT(id) FROM street WHERE valid >= 6 ) AS totalRef,
        ( SELECT COUNT(id) FROM street ) AS total,( SELECT COUNT(id) FROM users ) AS totalUsers ;");

        return $this->fetch($sql);
    }

    public function addPost( array $params): string
    {
        // nouvelle fiche
        $sql = ("INSERT INTO `street`
  (`id`, `name`, `adresse`, `photo`, `description`, `dateCreation`, `dateFiche`, `valid`, `statut`, `id_user`, `categorie`,`latitude`,`longitude`)
  VALUES (NULL, :name, :adresse, :photo, :description, :dateCreation, NOW(), :valid, :statut, :user, :categorie, :latitude, :longitude );");


        $params = ([
            'name' => $params['name'],
            'adresse' => $params['adresse'],
            'photo' => $params['photo'],
            'description' => $params['description'],
            'dateCreation' => $params['dateCreation'],
            'valid' => '2',
            'statut' => '1',
            'user' => $params['user'],
            'categorie' => $params['categorie'],
            'latitude' => $params['latitude'],
            'longitude' => $params['longitude'],
        ]
        );
//debug($sql,$params);
        // var_dump($sql,$params);
        return  $this->into($sql, $params);
    }


    public function delPost(array $params): int
    {
        //supretion fiche
        $sql = ("SELECT photo FROM `street` WHERE `id` = :id ;");
        $params = ([
            'id' => $params['id'],
        ]
        );

        $photo = $this->fetch($sql, $params);

        if (isset($photo['photo'])) {
            unlink('./img/' . $photo['photo']);

        }

        $sql = ("DELETE FROM `validation` WHERE `validation`.`id_street` = :id ;");

        $params = ([
            'id' => $params['id'],
        ]
        );

        $number = $this->delt($sql, $params);

        $sql = ("DELETE FROM `street` WHERE `street`.`id` = :id ;");

        $params = ([
            'id' => $params['id'],
        ]
        );

        $post = $this->delt($sql,$params );
        return $post;
    }

    public function setPost(array $params): int
    {
        // modification fiche
        $sql = ("UPDATE `street` SET `name` = :name ,
  `description` = :description ,`adresse` = :adresse ,`categorie` = :categorie ,
  `dateCreation` = :dateCreation ,`categorie` = :categorie ,`statut` = :statut ,
   `valid` = :valid
  WHERE `street`.`id` = :id ;");
        $params = ([
        'name'=>$_POST['name'],
        'adresse'=>$_POST['adresse'],
        'description'=>$_POST['description'],
        'dateCreation'=>$_POST['dateCreation'],
        'categorie'=>$_POST['categorie'],
        'statut'=>$_POST['statut'],
        'valid'=>$_POST['valid'],
        'id'=>$_GET['id']
        ]
        );

        return $this->update($sql, $params);
    }

     public function setPostArchiv(array $params): int
    {
        //chagement de statut d'une fiche
          $sql = ("UPDATE `street` SET `statut` = :statut WHERE `street`.`id` = :id ;");
         $params = ([
        'statut'=>'1',
        'id'=>$params['id']
        ]
        );

        return $ok = $this->update($sql, $params);
    }
}
