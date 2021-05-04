<?php
declare(strict_types=1);

abstract class Layout
{
 protected string $titre;
  protected string $destruction;
  protected string $template;
  protected string $layout;

 
  // contruction du layout
    public function __construct(string $template = 'accueil',$url=[])
     {
     ob_start();

     $this->root = '.';
     if ($url[1]){
     $this->root = '..';
     }
     
     $this->template = strtolower($template);
     $this->index='index.php' ?? 'index.php';
// pour le referencement nature
   $this->titre = ucfirst($this->template.' streetArt') ?? 'streetart';
   $this->keywords=ucfirst($this->template.', streetArt, rue') ?? 'streetart';
    $this->description = ucfirst($this->template.' découverte street Art référencé par des internaute passionnée dans leur ville.');
    $this->content="";
    $this->layout = './templates/layout.phtml';
ob_get_clean();
  
   // fermeture base
   $this->pdo = null ;
     }


}