<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");
$titre = 'street art';

define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
$root = dirname(__DIR__).DIRECTORY_SEPARATOR;

require_once(ROOT.'/app/Database.php');
require_once(ROOT.'/app/function.php');

use street\Users;
use street\Vue;
use street\Modif;

require_once(ROOT.'/models/Votes.php');
require_once(ROOT.'/models/Messages.php');
require_once(ROOT.'/models/Posts.php');
require_once(ROOT.'/models/Categorie.php');
require_once(ROOT.'/models/Comments.php');
require_once(ROOT.'/models/Statuts.php');
require_once(ROOT.'/models/Users.php');
$users = new Users();

require_once(ROOT.'/controller/vue.php');
require_once(ROOT.'/controller/modif.php');

/* selon les droit adminitratif
* affichage d'une partie des post
*/

    if (!empty($_SESSION['auth']))
    {
    $droits =$users->droit($_SESSION['auth']['user_id']);
    }else{
    $droits =$users->droit('');
    }


/* routeur */
$url=null;
if (isset($_GET['p']))
{
    if (isset($_GET['p']))
    {
        $url = explode('/', $_GET['p']);
    
        $p = $url[0];
    
        if (empty($url[0])){
            $p='accueil';
        }
    $p = strtolower(htmlentities(trim($_GET['p']), ENT_QUOTES));
    } else {
        $p='accueil';
    }

    if (isset($_GET['id']))
    {
    $id = strtolower(htmlentities(trim($_GET['id']), ENT_QUOTES));
   // on force int si numeric
     if (is_numeric($id))
      {
      $id= $id;
      }
    }
    if (isset($_GET['idp']))
    {
    $idp = strtolower(htmlentities(trim($_GET['idp']), ENT_QUOTES));
  
      $idp= ($idp);
     
    }
    if (!empty($url[1]))
    {
    $id = strtolower(htmlentities(trim($url[1]), ENT_QUOTES));
   // on force int si numeric
     if (is_numeric($id))
      {
      $id= $id;
      }
    } 

}else {
    $p='accueil';
}

    if (isset($_GET['e']))
    {
    $e = $_GET['e'];
    }else{
    $e= 0 ;
    }


    if (isset($p))
    {
    $vue = new Vue($p,$url);
    $modifs = new Modif();
    
    switch ($p){
        //page acceuil
            case "acceuil":
            $vue->getAccueil($droits);
            break;
        //page galerie
       case "galerie":
    
        $vue->getGalerie($droits);
    
        break;
    //fiche detail
        case "detail":
            if (isset($id))
            {
            $id = str_replace('street_', '', $id);
            // on verifie si id est numerique si on recuper id de la fiche
    
            $vue->getDetail($droits,$id);
            } else {
            // si fiche n'est pas trouver'
            $vue->get404();
            }
        break;
    //plan
        case "plan":
    
             $vue->getPlan();
        break;
    // sugestion
        case "suggestion":
            $vue->getSuggestion($e);
        break;
    //contact
        case "contact":
    
             $vue->getContact($e);
        break;
    // envoie mail de contact
        case "adcontact":
    
             $modifs->setContact($e);
        break;
    // creation de compte
        case "addcompte":
    
             $vue->getAddcompte();
        break;
    // connection
        case "connection":
    
             $vue->getConnection($e);
        break;
    // verification la connection
        case "setconnection":
             $modifs->setConnection();
        break;
    // oublier
        case "oublier":
             $vue->getOublier();
        break;
    // modifi de mot passe oubmier
       case "setoublier":
             $modifs->setOublier();
        break;
    //propos
        case "propos":
            $vue->getPropos();
        break;
    //juex
        case "jeux":
    
           $vue->getJeux();
        break;
    // liste des messege pour admin
        case "message":
            if ($droits['droit'] == 9)
            {
            $vue->getMessage();
            }else{
             $vue->get404();
            }
    
        break;
    // del message
     case "delmessage":
            if ($droits['droit'] == 9)
            {
            $modifs->delMessage($id);
            }else{
             $vue->get404();
            }
    
        break;
    // liste des user menbre pour admin
        case "menbre":
           if ($droits['droit'] == 9)
            {
            $vue->getMenbre();
    
             } else {
             $vue->get404();
            }
        break;
    // compte
        case "compte":
            if(!empty($_SESSION['auth']))
            {
            $vue->getCompte();
            } else {
            $vue->get404();
            }
        break;
    // creation compte
      case "adcomptes":
            if(isset($_POST))
            {
            $modifs->addComptes();
            } else {
            $vue->get404();
            }
        break;
      // getion categorie pour adimn
        case "categorie":
            if ($droits['droit'] == 9)
            {
    
            $vue->getCategorie();
    
            } else {
             $vue->get404();
            }
        break;
    // modif categorie par admin
      case "setcategorie":
            if ($droits['droit'] == 9)
            {
    
            $modifs->setCategorie();
            } else {
             $vue->get404();
            }
        break;
    // mise en achive
         case "archive":
           
            $modifs->setArchive((int) $id);
          
        break;
    
    // del fiche post
        case "delposts":
            if (!empty($id))
            {
            $modifs->delPosts($id);
            }else {
            $vue->get404();
            }
        break;
    // mdoif vote
        case "vote":
            
            $modifs->vote($id,$_GET['vote'] );
           
        break;
    // creation fiche post
         case "upposts":
            if (!empty($_FILES) && $_FILES['photo']['error'] == 1)
            {
            $_FILES['photo']=null;
            $vue->getSuggestion(2);
            }
    
           if (!empty($_POST))
            {
            $modifs->upPosts($id);
            } else {
            $vue->get404();
            }
        break;
    // modif fiche post
         case "setposts":
    
           if (!empty($_POST))
            {
            $modifs->setPosts();
            } else {
            $vue->get404();
            }
        break;
    // del catgorie par admin
          case "delcategories":
            if ($droits['droit'] == 9)
            {
    
            $modifs->delCategories();
    
            } else {
             $vue->get404();
            }
        break;
    // modif droit par admin
          case "updroit":
            if ($droits['droit'] == 9)
            {
    
            $modifs->updroit($id);
    
            } else {
             $vue->get404();
            }
        break;
    // liste des comments pour admin
        case "comment":
            if(!empty($_SESSION['auth']))
            {
            $vue->getComment();
            } else {
             $vue->get404();
            }
    
        break;
    // ajout comment
      case "setcomment":
            if(!empty($_SESSION['auth']))
            {
            $modifs->setComment($droits);
            } else {
             $vue->get404();
            }
    
        break;
    // del comment
        case "delcomment":
            if(!empty($_SESSION['auth']))
            {
               
            $modifs->delComments((int) $id,(int) $idp);
            } else {
             $vue->get404();
            }
    
        break;
    // del user menbre
          case "delmenbre":
            if(!empty($_SESSION['auth']))
            {
            $modifs->delMenbre($id);
            } else {
             $vue->get404();
            }
    
        break;
    // liste des fiches
        case "street":
        
            if(!empty($_SESSION['auth']) )
            {
            $vue->getStreet($droits);
    
            } else {
           $vue->get404();
            }
        break;
    // modif des fiche street
        case "modif":
            if (!empty($_SESSION['auth']))
            {
                if (!empty($id))
                {
                $vue->getModif($droits,$id);
                } else {
                $vue->get404();
              }
            } else {
            $vue->get404();
            }
        break;
    // deconection
        case "deconnec":
          $modifs->getDeconnec();
        break;
    
        case "404":
         $vue = new Vue('404');
       $vue->get404();
          break;
    
        default:
       $vue = new Vue('accueil',$url);
        $vue->getAccueil($droits);
        break;
        }
    
    
    // la fameuse page 404
       
    
        // $vue = new Vue('404');
      // $vue->get404();
       // break;
    
    
    } else {
    // par default
      // $vue = new Vue('accueil',$url);
      //  $vue->getAccueil($droits);
      $vue = new Vue('404');
      $vue->get404();
    }