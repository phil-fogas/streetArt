<?php
declare(strict_types=1);

abstract class Layout
{
 protected string $titre;
  protected string $description;
  protected string $template;
  protected string $layout;

 
  // contruction du layout
    public function __construct(string $template = 'accueil',$url=[])
     {
     ob_start();

     $this->root = '.';
     $this->root2 = '..';
     
     if (isset($url[1])){
     $this->root = '..';
     }
    
     $this->template = strtolower($template);
// pour le referencement nature
  $this->index ='./' ?? 'index.php';
  if (isset($url[1])){
    $this->index ='../' ?? './index.php';
    }
   $this->titre = ucfirst($this->template.' streetArt lyon') ?? 'streetart';
   $this->keywords = ucfirst($this->template.', streetArt, street Art, Lyon, rue de Lyon, passion.fr') ?? 'street Art, streetart, lyon, passion';
    $this->description = ucfirst($this->template.' découverte street Art référencé par des internaute passionnée dans leur ville.');
    $this->content="";
    $this->layout = './templates/layout.phtml';

ob_get_clean();
   //require_once $this->layout;
   //return $this;
   $this->pdo = null ;
     }


}