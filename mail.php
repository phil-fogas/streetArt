<?php


function validate_email($email)
{

$testmail = filter_var($email, FILTER_VALIDATE_EMAIL);

if($testmail == TRUE)
   {
var_dump(((explode("@",$email))));
list($compte, $domaine) = explode("@",$email);
    if(checkdnsrr($domaine,"MX") && checkdnsrr($domaine, "A"))
	  {
      echo"Le domaine et l'adresse sont valide";
      }
	  else
	  {
      echo"Le domaine n existe pas...Adresse invalide!";
      }

   }
   else
   {
   echo"L'adresse e-mail semble non valide...Vous avez du faire une erreur!";
   }
}

validate_email("phileas@mail.fr");
