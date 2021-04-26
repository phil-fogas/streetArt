<?php
declare(strict_types=1);
namespace street;
require_once(ROOT.'/controller/layout.php');

use Layout;

// class qui controle et genere les vues
class Vue extends Layout
{


    public function __construct(string $template = 'accueil',$url=[])
     {
     
         parent::__construct($template,$url);

     }
// page 404
 public function get404(): void
 {
    $this->titre = '404';
    $this->description = 'page 404 est la';
    http_response_code(404);
    $this->template = '404';
    require_once $this->layout;
 }
// page propos
 public function getPropos(): void
 {

     $posts = new Posts();
     $count=$posts->countPostAll();
     //return  $this->content='propos.phtml';
     require_once $this->layout;
 }
//page galerie
 public function getGalerie(array $droits ): void
   {

      $categorie = new Categorie();
      $categories = $categorie->getCategorieAll();
   
    require_once $this->layout;
    }
//page acceuil
 public function getAccueil(array $droits): void
   {
    $posts = new Posts();
    $streets = $posts->getPostAllrandom($droits['valid'], $droits['statut'],3);
    $count = $posts->countPostAll();
    $bonjour = bienvenu();
   require_once $this->layout;
   }

//page fiche detail
    public function getDetail(array $droits, string $id): void
    {
     $posts = new Posts();
     
        // on verifie si id est numerique si on recuper id de la fiche

            if (is_numeric($id))
            {
            $street = $posts->getPost($id);
             } else {
            $street = $posts->getPostName($id);
            }

            if (!empty($street))
            {
            $comments = new Comments();
            $votes = new Votes();
            $idc = $street['id'];
            $comments = $comments->getComments($idc);
            $vote = $votes->vote($idc);
            require_once $this->layout;
            } else {
             $this->get404();
            }

    }
//page plan
    public function getPlan(): void
    {

        require_once $this->layout;
    }
//page suggestio
    public function getSuggestion($e = 0): void
    {
        $e =$e;
        $categories = new Categorie();
        $categories = $categories->getCategorieAll();
        require_once $this->layout;
    }
//page contact
    public function getContact(int $e = 0): void
    {
        $e = $e;
       require_once $this->layout;
    }
//page compte
    public function getAddcompte(): void
    {

        require_once $this->layout;
    }
//page connection
    public function getConnection(int $e = 0): void
    {
        $e = $e;
        require_once $this->layout;
    }
//page oublier
    public function getOublier(): void
    {

        require_once $this->layout;
    }

//page jeux
    public function getJeux(): void
    {

        $stript='ping.js';
        require_once $this->layout;
    }
//page message
    public function getMessage(): void
    {
       $messages = new Messages();
        $messages=$messages->getMessageAll();
        require_once $this->layout;

    }
//page menbre
    public function getMenbre(): void
    {
       $users = new Users();
        $users = $users->getMenberAll();
        require_once $this->layout;

    }
//page compte
    public function getCompte(): void
    {
      $bonjour = bienvenu();
        require_once $this->layout;

    }
//page categorie
    public function getCategorie(): void
    {

        $categories = new Categorie();
        $categories = $categories->getCategorieAll();
        require_once $this->layout;

    }
// page commentaire
    public function getComment(): void
    {
      $comments = new Comments();
      $comment = $comments->getCommentsAllMenber($_SESSION['auth']['user_id']);

            if ($_SESSION['auth']['droit'] == 9 || $_SESSION['auth']['droit'] == 5)
            {
            $commentsAll = $comments->getCommentsAll();
            }

       require_once $this->layout;
    }
//page litse street
    public function getStreet(array $droits): void
    {
       $posts = new Posts();
         // si user est inscript
            if ($_SESSION['auth']['droit'] == 2 && $droits['droit'] == 2)
            {
             $streets = $posts->getPostAllMenber($_SESSION['auth']['user_id']);
            }
        // si user est admin ou moderateur
            if ($_SESSION['auth']['droit'] == 9 && $droits['droit'] == 9 || $_SESSION['auth']['droit'] == 5 && $droits['droit'] == 5)
            {
            $streetAll = $posts->getPostAllMenbers();

            }
             
      require_once $this->layout;
    }
// page mofifier fiche
 public function getModif(array $droits, string $id): void
    {
     $posts = new Posts();
        $street = $posts->getPost($id);
        //var_export($street);
                if (isset($street))
                {
                // droit de modifier selon les droits
                 if ($droits['droit'] == 9 || $droits['droit'] == 5 || $_SESSION['auth']['pseudo']==$street['pseudo'])
                    {
                        $statuts = new Statuts();
                        $categories = new Categorie();
                        $categories = $categories->getCategorieAll();
                        $statuts = $statuts->getStatutAll();
                        require_once $this->layout;
                     }
                 } else {
                $this->get404();
                }

      }



}

