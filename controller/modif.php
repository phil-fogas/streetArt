<?php
declare(strict_types=1);
namespace street;
require_once(ROOT.'/controller/layout.php');

use Layout;
/* class controle est renvoie vers les pages une fois donnee traite 
* avec redirection apres saissie utiliseateur
*/
class Modif extends Layout
{
private $host = ''; // URL to redirect

      public function __construct(string $template = 'accueil')
     {
         parent::__construct($template);

     }
// function de redirection #string page "int $id #e pour les eureures
     public function redirection(string $page, int $id = 0, int $e = 0 )
     {

     $url="index.php?p=".$page."";
     
      if (!empty($id))
     {
     $url.="&id=".$id;
     }
      if (!empty($e))
     {
     $url.="&e=".$e;
      }
      if (empty($url))
      {
      $url=$_SERVER['HTTP_REFERER'];
      }
        http_response_code(200);
      header("Location: ".$this->host."".$url."");
      exit();
     }

// deconnection
     public function getDeconnec(): void
    {

        $_SESSION = array();
        session_destroy();
      
         $this->redirection('accueil');
    }
// connection
 public function setConnection(): void
    {
      $users = new Users();


        if (isset($_POST['pseudo']))
       {

        $params = ([
        'email' => $_POST['pseudo']
            ]);
        // verrication si user est present
        $login = $users->getUser($params);

        if (empty($login))
        {
            
             $this->redirection('connection',0,2);
        } else {

        //verification du mot de pass
        if (password_verify($_POST['password'], $login['password']))
        {
           $_SESSION['auth'] = [
                'user_id' => $login['id'],
                'pseudo' => $login['pseudo'],
                'droit' => $login['droit']
            ];

            $params = ([
                'id' => $login['id']
            ]);

        // mise a jour date dermiere visite
        $ok=$users->setUserTime($params);

            if (isset($ok))
            {
             
             $this->redirection('compte');
            } else {
            $this->redirection('connection',0,2);
             
            }

        } else {
        $this->redirection('connection',0,2);
        
        }

      }

    }

 }
// modif des categorie
  public function setCategorie(): void
    {
        $categories = new Categorie();

         if (!empty($_POST))
        {
               $params = ([
                    'name'=>$_POST['categorieAd'],
                        ]);
        //var_dump($params);

        $categories->setCategorie($params);

        $this->redirection('categorie');
        }

    }
    // modif des droit
  public function updroit($id): void
    {
       

        if ($_GET['d']=='menbre')
        {
        $droit=5;
        }
        if ($_GET['d']=='modérateur')
        {
        $droit=2;
        }

    $params = ([
        'id'=>$id,
        'droit'=>$droit,
        ]
        );

    $users = new Users();
    $users->setUserDroit($params);

    $this->redirection('menbre');


  }
// del categorie
    public function delCategories(): void
    {
     $categories = new Categorie();

         $params = ([
        'id'=>$_POST['categorieDel'],
        ] );

        $categories->delCategorie($params);
       
        $this->redirection('categorie');
    }
// ajjoute commentaire
    public function setComment(array $droits)
    {
        $comments = new Comments();
    // traitement $_POST
        if (!empty($_POST))
        {
        $params = ([
        nl2br(htmlspecialchars($_POST['user_id'])),
        nl2br(htmlspecialchars($_POST['comment'])),
        $_POST['street'],
        ]);
        $res = $comments->addComments($params);
        
        $id = $_POST['street'];
        
         $this->redirection('detail',$id);
        }
    }
// del comment
    public function delComments(int $id): void
    {
        $comments = new Comments();
    // traitement $_POST
        $params = ([
        'id' => $_GET['id'],
             ]);

    $number = $comments->delComment($params);
    $this->redirection('comment');
    }
// archive fiche
 public function setArchive(int $id): void
    {
        $posts = new Posts();
    // archivage
    $params = ([
        'id'=>$id
        ]);

        $posts->setPostArchiv($params);
        $this->redirection('street',$id);
   
    }
//del user menber
  public function delMenbre(int $id): void
    {
        $users = new Users();
          $params = ([
        'id'=>$id,
            ]);

    $users->delUser($params);
  
    $this->redirection('menbre');
    }
//del message
 public function delMessage(): void
    {
    $messages = new Messages();

// supretion message
    $params = ([
        'id' => $_GET['id'],
    ]);

    $number = $messages->delMessage($params);
    $this->redirection('message');
    }
//del post
    public function delPosts($id): void
    {
      $posts = new Posts();
       $params = ([
        'id' => $id,
            ]);

    $number = $posts->delPost($params);

    $this->redirection('street');
    }
// creation de compte
   public function addComptes(): void
    {
        $users = new Users();
        $_POST['email'] = nl2br(htmlspecialchars($_POST['email']));
// netoyage et validation mail selon format
        $testmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if($testmail == TRUE)
        {
        // verrication si le serveur du domaine du mail est reel
        list($compte, $domaine) = explode("@",$_POST['email']);
            if(checkdnsrr($domaine,"MX"))
             {
                $_POST['email']=$_POST['email'];

            } else {
            $_POST['email']=null;
            $vue->getGalerie($droits);

            }
        }

        if (!empty($_POST['email']))
        {
        $params = ([
            'email'=>$_POST['email'],
            ]);

        $user = $users->getUser($params);
    // var_dump($user);
    //verrification si user present
        if (empty($user))
        {
        $params = ([
            'pseudo'=>nl2br(htmlspecialchars($_POST['pseudo'])),
            'email'=>$_POST['email'],
            'password'=>$_POST['password'],
            ]);

        $id = $users->addUser($params);
        // var_dump($id);
        // ouverture de la session
        if (!empty($id))
            {
            $_SESSION['auth']=[
                'user_id'=>$id,
                'pseudo'=>nl2br(htmlspecialchars($_POST['pseudo'])),
                'email'=>nl2br(htmlspecialchars($_POST['email'])),
                'droit'=>'2',
                ];
            

            }
            $this->redirection('compte');
        }
        
        }
    $this->redirection('galerie');
    }
// modifie le mot de passe oublier
    public function setOublier(): void
    {
     $users = new Users();
         $params = ([
        'email'=>$_POST['email'],
        'pseudo'=>$_POST['pseudo'],
        ]);
    // verification si user est present
        $user=$users->getUserOublier($params);
    var_export($user);
        if (!empty($user))
        {
            $params = ([
            'id'=>$user['id'],
            'password'=>$_POST['password'],
            ]);

        $id=$users->upUser($params);

        // si present
        if (!empty($id))
            {
            $_SESSION['auth']=[
                'user_id'=>$user['id'],
                'pseudo'=>$user['pseudo'],
                'email'=>$user['email'],
                'droit'=>$user['droit'],
                ];
            $this->redirection('compte');
            $_SESSION['insc']=true;
            } else {
           $this->redirection('galerie');
            $_SESSION['insc']=false;
            }
      }
      $this->redirection('galerie');
    }
// modifie les fiches
    public function upPosts(string $id): void
    {
    $posts = new Posts();
     if (!$_POST['dateCreation']){$_POST['dateCreation']=null;}

    $params = ([
        'name'=>$_POST['name'],
        'adresse'=>$_POST['adresse'],
        'description'=>$_POST['description'],
        'dateCreation'=>$_POST['dateCreation'],
        'categorie'=>$_POST['categorie'],
        'statut'=>$_POST['statut'],
        'valid'=>$_POST['valid'],
        'id'=>$id
        ]);

        $posts->setPost($params);

        $this->redirection('detail',(int) $id);
    }

// creation de post
    public function setPosts(): void
    {
    // verifie si image passer sans js
       if(!empty($_POST['image']))
        {
        // traitement de l'image
            $extensions=mime_content_type($_POST['image']);
            $extension = substr($extensions, 6);
            $mime = substr($extensions,0,-4);
            $photo=uniqid() . '.' . $extension;
            $img = str_replace('data:'.$extensions.';base64,', '', $_POST['image']);

            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            
            // pas de data annulation image
            if (!$data)
            {
            $_POST['image']=null;
            }

            // verification si ces une image
            if (empty($mime) || strpos($mime, 'image/') !== 0)
            {
            $_POST['image']=null;
            }

            // verification si bon format image autorise
            if (!in_array($extension, ['png', 'gif', 'jpeg']))
            {
            $_POST['image']=null;
            }

        if (in_array($extension, ['png', 'gif', 'jpeg']))
        {
       
        // enregistre des donnee image
        file_put_contents('./uploads/'.$photo, $data);
        // tranfert de l'image
        $imag=array('tmp_name'=>'./uploads/'.$photo,'name'=>$photo);
// transfere image
           if ($imag)
           {
           $name = transfertImage($imag);
           }
        }
 
        }
 // image passer avec js pour un traitement en base64
        elseif (empty($_FILES['photo']['tmp_name']))
        {
        $name = null;
        } elseif(!empty($_FILES['photo']['tmp_name']))
        {
// tranfert image et redimention de la taille
        $name = transfertPhoto($_FILES['photo']);
        }

        if (!$_POST['dateCreation'])
        {
        $_POST['dateCreation'] = null;
        }

        if (!$_POST['categorie'])
        {
        $_POST['categorie'] = 1;
        }
// recuperation gps si pas entrer dans le formullaire
    if (!$_POST['latitude'] || !$_POST['longitude'])
    {
        $adresse=str_replace(' ', '+',$_POST['adresse']);
        $urls='https://api-adresse.data.gouv.fr/search/?q='.$adresse.'&lat=45.75&lon=4.85';
        $result = file_get_contents($urls);
        $json = json_decode($result, true);

        if($json['features'])
        {
        $_POST['latitude']=$json['features'][0]['geometry']['coordinates'][1];
        $_POST['longitude']=$json['features'][0]['geometry']['coordinates'][0];

        } else {
        
        $this->redirection('suggestion',0,2);
        }
    }
    
// envoie des donnée si tout est bon
        if ($_POST['latitude'] && !empty($name) )
        {
        $params = ([
        'name' => nl2br(htmlspecialchars($_POST['name'])),
        'adresse' => nl2br(htmlspecialchars($_POST['adresse'])),
        'photo' => $name,
        'description' => $_POST['description'],
        'dateCreation' => $_POST['dateCreation'],
        'user' => $_POST['user_id'],
        'categorie' => $_POST['categorie'],
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude'],
        ]);
        //var_export($params);
        $posts = new Posts();
        $id = $posts->addPost($params);
        $this->redirection('suggestion',0,1);
        } else {
        // si probleme
       
        $this->redirection('suggestion',0,3);
         }
        
 }
// envoie message de la page conctact
  public function setContact(): void
  {

   if (!$_POST['email'] && $_SESSION['auth']['pseudo'])
     {
    $_POST['email'] = $_SESSION['auth']['pseudo'];
     
      }
  $erreur = 3;
  $sujet = addslashes($_POST['sujet']);
  $mail = addslashes($_POST['email']);
  $message = addslashes($_POST['message']);

  if(empty($sujet))
  {
  $sujet="message de ".$mail;
  }

  if (isset($_POST['email']))
  {
  $envoi = "graph@la-passion.fr";
  // netoyage et validation mail selon format
   $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

   //traitement mail
   $mail = trim(preg_replace("/[\r\n]+/", "", $mail));
   $passage_ligne = "\r\n";
   $header = "";
   $header .= "MIME-Version: 1.0" . $passage_ligne;
   $header .= "Subject: $sujet " . $passage_ligne;
   $header .= "Date: " . date('r') . $passage_ligne;
   $header .= "From: $mail " . $passage_ligne;
   $message = (wordwrap($message, 70, $passage_ligne));
   $message = htmlentities(preg_replace("/[\r\n]+/", "", $message), ENT_QUOTES, 'UTF-8');

   $message = $passage_ligne . $message . $passage_ligne;

   $message = str_replace("\n.", "\n..", $message);
   }

// verrification si post est pas vide et mail est bon format
   if (!empty($_POST) && filter_var($mail, FILTER_VALIDATE_EMAIL))
    {

// envoie mail

    $verif_envoi_mail = @mail($envoi, $sujet, $message, $header);
    // verrifier si y a envoie mail
    
       if ($verif_envoi_mail === FALSE)
       {
        $erreur = 2;

        } else {
        $erreur = 1;

        }

    }

// si pas envoi mail faute de serveur ou autre
// saugarde en mp dans le site
   if (isset($erreur))
   {
    $params = ([
        'email' => $mail,
        'message' => $_POST['message'],
        'sujet' => $sujet,
    ]);
//var_export($params);
    $messages = new Messages();
    $messages->addMessage($params);

    }
    unset($_POST);

     $this->redirection('contact',0,$erreur);
     
 }
// traitement des votes
     public function vote(int $id): void
     {
       $votes = new Votes();
       $val=1;

 // si admin ou moderateur vaut 5
    if ($_SESSION['auth']['droit']==5||$_SESSION['auth']['droit']==9)
    {
    $val=5;
    }
// addition sous soutration des vote
    if ($_GET['vote']=='oui')
    {
    $valid=+$val;
    }

    if ($_GET['vote']=='non')
    {
    $valid=-$val;
    }


    $params = ([
    'user_id'=>$_SESSION['auth']['user_id'],
    'vote'=>$_GET['vote'],
    'valid'=>$valid,
    'id'=>$_GET['id']
    ]);

    $votes->addVote($params);

    $this->redirection('detail',$id);
   }

}