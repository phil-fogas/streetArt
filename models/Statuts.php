<?php
declare(strict_types=1);

namespace street;
use Database;

class Statuts extends Database
{


    public function __construct()
    {
        parent::__construct();


    }
    public function getStatutAll(): array
    {
        //le statut de la fiche
        $sql = ("SELECT id,statut FROM `statut` ;");

        $statuts = $this->fetchAll($sql);
        return $statuts;
    }

}