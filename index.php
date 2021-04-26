<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR");
$titre = 'street art';

define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
$root ='.';
require_once(ROOT.'/app/Database.php');


require_once(ROOT.'/app/function.php');

use street\Categorie;
use street\Comments;
use street\Users;
use street\Posts;
use street\Statuts;
use street\Messages;
use street\Votes;
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
if (isset($_GET))
{
    if (isset($_GET['p']))
    {
    $p = strtolower(htmlentities($_GET['p'], ENT_QUOTES));
    }

    if (isset($_GET['id']))
    {
    $id = strtolower(htmlentities($_GET['id'], ENT_QUOTES));
   // on force int si numeric
     if (is_numeric($id))
      {
      $id=(int) $id;
      }
    }
    if (isset($_GET['e']))
    {
    $e = (int) $_GET['e'];
    }else{
    $e=0;
    }
}


if (isset($p))
{
$vue = new Vue($p);
$modifs = new Modif();

//page acceuiel
 if ($p =='accueil')
    {
    $vue->getAccueil($droits);
    }
//page galeerie
   elseif ($p == 'galerie')
    {

    $vue->getGalerie($droits);

    }
//fiche detail
    elseif ($p == 'detail')
    {
        if (isset($id))
        {
        $id = str_replace('street_', '', $id);
        // on verifie si id est numerique si on recuper id de la fiche
        $vue->getDetail($droits,$id);
        } else {
        // si fiche n'est pas trouver'
        $vue->get404();
        }
    }
//plan
    elseif ($p == 'plan')
    {

         $vue->getPlan();
    }
// sugestion
    elseif ($p == 'suggestion')
    {
        $vue->getSuggestion($e);
    }
//contact
    elseif ($p == 'contact')
    {

         $vue->getContact($e);
    }
// envoie mail de contact
    elseif ($p == 'adcontact')
    {

         $modifs->setContact($e);
    }
// creation de compte
    elseif ($p == 'addcompte')
    {

         $vue->getAddcompte();
    }
// connection
    elseif ($p == 'connection')
    {

         $vue->getConnection($e);
    }
// verification la connection
    elseif ($p == 'setconnection')
    {
         $modifs->setConnection();
    }
// oublier
    elseif ($p == 'oublier')
    {
         $vue->getOublier();
    }
// modifi de mot passe oubmier
   elseif ($p == 'setoublier')
    {
         $modifs->setOublier();
    }
//propos
    elseif ($p == 'propos')
    {
        $vue->getPropos();
    }
//juex
    elseif ($p == 'jeux')
    {

       $vue->getJeux();
    }
// liste des messege pour admin
    elseif ($p == 'message')
    {
        if ($droits['droit'] == 9)
        {
        $vue->getMessage();
        }else{
         $vue->get404();
        }

    }
// del message
 elseif ($p == 'delmessage')
    {
        if ($droits['droit'] == 9)
        {
        $modifs->delMessage($id);
        }else{
         $vue->get404();
        }

    }
// liste des user menbre pour admin
    elseif ($p == 'menbre')
    {
       if ($droits['droit'] == 9)
        {
        $vue->getMenbre();

         } else {
         $vue->get404();
        }
    }
// compte
    elseif ($p == 'compte')
    {
        if(!empty($_SESSION['auth']))
        {
        $vue->getCompte();
        } else {
        $vue->get404();
        }
    }
// creation compte
  elseif ($p == 'adcomptes')
    {
        if(isset($_POST))
        {
        $modifs->addComptes();
        } else {
        $vue->get404();
        }
    }
  // getion categorie pour adimn
    elseif ($p == 'categorie')
    {
        if ($droits['droit'] == 9)
        {

        $vue->getCategorie();

        } else {
         $vue->get404();
        }
    }
// modif categorie par admin
  elseif ($p == 'setcategorie')
    {
        if ($droits['droit'] == 9)
        {

        $modifs->setCategorie();
        } else {
         $vue->get404();
        }

// mise en achive
     elseif ($p == 'archive')
    {
       
        $modifs->setArchive((int) $id);
      
    }

// del fiche post
    elseif ($p == 'delposts')
    {
        if (!empty($id))
        {
        $modifs->delPosts($id);
        }else {
        $vue->get404();
        }
    }
// mdoif vote
    elseif ($p == 'vote')
    {
        
        $modifs->vote($id);
       
    }
// creation fiche post
     elseif ($p == 'upposts')
    {
        if (!empty($_FILES) && $_FILES['photo']['error']==1)
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
    }
// modif fiche post
     elseif ($p == 'setposts')
    {

       if (!empty($_POST))
        {
        $modifs->setPosts();
        } else {
        $vue->get404();
        }
    }
// del catgorie par admin
      elseif ($p == 'delcategories')
    {
        if ($droits['droit'] == 9)
        {

        $modifs->delCategories();

        } else {
         $vue->get404();
        }
    }
// modif droit par admin
      elseif ($p == 'updroit')
    {
        if ($droits['droit'] == 9)
        {

        $modifs->updroit($id);

        } else {
         $vue->get404();
        }
    }
// liste des comments pour admin
    elseif ($p == 'comment')
    {
        if(!empty($_SESSION['auth']))
        {
        $vue->getComment();
        } else {
         $vue->get404();
        }

    }
// ajout comment
  elseif ($p == 'setcomment')
    {
        if(!empty($_SESSION['auth']))
        {
        $modifs->setComment();
        } else {
         $vue->get404();
        }

    }
// del comment
    elseif ($p == 'delcomment')
    {
        if(!empty($_SESSION['auth']))
        {
        $modifs->delComments($id);
        } else {
         $vue->get404();
        }

    }
// del user menbre
      elseif ($p == 'delmenbre')
    {
        if(!empty($_SESSION['auth']))
        {
        $modifs->delMenbre($id);
        } else {
         $vue->get404();
        }

    }
// liste des fiches
    elseif ($p == 'street')
    {
    
        if(!empty($_SESSION['auth']) )
        {
        $vue->getStreet($droits);

        } else {
       $vue->get404();
        }
    }
// modif des fiche street
    elseif ($p == 'modif' )
    {
        if (!empty($_SESSION['auth']))
        {
            if (!empty($id))
            {
            $vue->getModif($droits,(int)$id);
            } else {
            $vue->get404();
          }
        } else {
        $vue->get404();
        }
    }
// deconection
    elseif ($p == 'deconnec' )
    {

      $modifs->getDeconnec();

    }
// la fameuse page 404
    else {

     $vue = new Vue('404');
    $vue->get404();
    }


} else {
// par default
   $vue = new Vue('accueil');
    $vue->getAccueil($droits);
}