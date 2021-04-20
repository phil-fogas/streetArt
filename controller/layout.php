<?php
declare(strict_types=1);

abstract class Layout
{
 protected string $titre;
  protected string $destruction;
  protected string $template;
  protected string $layout;

  // contruction du layout
    public function __construct(string $template = 'accueil')
     {
     $this->root = '.';
   $this->template = strtolower($template);
// pour le referencement nature
   $this->titre = ucfirst($this->template.' streetArt');
    $this->description = ucfirst($this->template.' découverte street Art référencé par des internaute passionnée dans leur ville.');
    $this->layout = $this->root.'/templates/layout.phtml';
   //require_once $this->layout;
     }

}