<?php
declare(strict_types=1);


abstract class Database
{
    protected PDO $pdo;
    protected $db;

    public function __construct()
    {
        // Charge le fichier de configuration config.json
        $config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);
        $connection = $config['connection'];
        try {

            if ($_SERVER['SERVER_ADDR'] === ":::1" || $_SERVER['SERVER_ADDR'] === "127:0:0:1" || $_SERVER['SERVER_NAME'] === "localhost") {
                $this->pdo = new PDO(
                    "mysql:host={$connection['host']};dbname={$connection['dbname']};charset=UTF8",
                    $connection['user'],
                    $connection['password'], [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } else {
                $this->pdo = new PDO(
                    "mysql:host={$connection['host']};dbname={$connection['dbname']};charset=UTF8",
                    $connection['user'],
                    $connection['password']
                );

            }
            $this->db= $this->pdo;
        } catch (PDOException $e) {
            echo 'Echec de la connexion : ' . $e->getMessage();
            exit;
        }

    }


    public function fetchAll(string $sql, array $params = []): array
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    }


    public function fetch(string $sql, array $params = []): array
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        //return $query->fetch();
        $user = $query->fetch();
        if ($user) {
            // var_dump("trouve ". $user);
            return $user;
        } else {
            //var_dump("vide ".$user);
            return array();

        }

    }

    public function into(string $sql, array $params): string
    {
        $id = 0;
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        $id = $this->pdo->lastInsertId();
        return $id;

    }

    public function delt(string $sql, array $params): int
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->rowCount();
    }

    public function update(string $sql, array $params = []): int
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->rowCount();
    }

    public function getPdo(): PDO
    {
        return $this->PDO;
    }

    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }
}