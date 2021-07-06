<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'utf-8');

$root ='.';
define('ROOT', str_replace('erreur.php','',$_SERVER['SCRIPT_FILENAME']));
use street\Vue;
require_once(ROOT.'/controller/vue.php');

 $crawler = false;  
$_GET['erreur'] = !empty($_GET['erreur']) ? $_GET['erreur'] : NULL;

// traduction code erreur
switch($_GET['erreur'])
{
   case '400':
   $ere= 'échec de l\'analyse HTTP.';
   break;
   case '401':
   $ere  = 'Le pseudo ou le mot de passe n\'est pas correct !';
   break;
   case '402':
   $ere = 'Le client doit reformuler sa demande avec les bonnes données de paiement.';
   break;
   case '403':
   $ere = 'Requète interdite !';
   break;
   case '404':
   $ere = 'page pas trouvé';
   break;
   case '405':
   $ere = 'Méthode non autorisée.';
   break;
   case '500':
   $ere = 'Erreur interne au serveur ou serveur saturé.';
   break;
   case '501':
   $ere = 'Le serveur ne supporte pas le service demandé.';
   break;
   case '502':
   $ere = 'Mauvaise passerelle.';
   break;
   case '503':
   $ere = ' Service indisponible.';
   break;
   case '504':
   $ere = 'Trop de temps à la réponse.';
   break;
   case '505':
   $ere = 'Version HTTP non supportée.';
   break;
   default:
   $ere = 'Erreur !';
}

// recuperer ip visiteur
function get_ip():string
 {

$keys=array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR');

   foreach($keys as $k)
    {
        if (!empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP))
        {
            $ip = $_SERVER[$k];
        }
    }
return trim($ip);
}

function smart_ip_detect_crawler() {
  return FALSE;
  $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $bot_identifiers = array(
    "antibot","appie1.1","archive","ask","askjeeves","baiduspider","converacrawler",
    "deepIndex","dloader","exabot","fast","fluffy","gigabot","girafabot",
    "google","google adsence","googlebot","googlebot-image","grub.org","googleusercontent",
    "henrilerobotmirago","heritrix","holmes","httrack","ia_archiver",
    "ichiro","inktomi slurp","java","larbin","lwp-trivial","mediapartners-google"
    ,"mj12bot","msnbot","msnbot-media","msiecrawler","msrbot","netresearchserver",
    "nimblecrawler","nutch","nutchcvs","openbot","openfind","picsearch","pompos","psbot",
    "python-urllib","sbider","seekbot","scooter","shinchakubin","slurp","spider","stackramber",
    "surveybot","szukacz","teoma","voila","voilabot","voyager","webcrawler","xenu link sleuth",
    "yandex","yahoo","yahoo!","yahoo-mmcrawler","yahooseeker","zyborg",
      "bot","slurp","crawler","spider","curl", "facebook", "fetch",
     "Teoma", "alexa", "froogle", "Gigabot", "inktomi",
    "looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
    "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
     "Scooter", "Slurp",
    "msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
    "Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
    "Mediapartners-Google", "Sogou web spider", "WebAlta
     Crawler","TweetmemeBot", "Butterfly", "Twitturls", "Me.dium",
     "Twiceler", "Purebot", "facebookexternalhit",
    "Yandex", "CatchBot", "W3C_Validator", "Jigsaw","PostRank",
    "Purebot", "Twitterbot",
    "Voyager", "zelist", "pingdom", "favicon",
    	"008"	, "80legs",
		"AbachoBOT" ,"AbachoBOT",
		"Accoona" , "Accoona",
		"Bing", "bingbot",
		"Dumbot", "Dumbot",
		"eStyle Bot", "eStyle",
		"FAST-WebCrawler" ,
		"GeonaBot" ,
		"Gigabot" , "Gecko",
		"Larbin",
		"MSN", "msnbot",
		"MSRBOT" , "MSRBOT",
		"Seekbot"	, "seekbot",
		"Scrubby robot", "Scrubby",
		"MJ12bot", "MJ12bot"," voilaBot",
		 "crawl", "adscanner","qwantbot","Qwantify",
 		"Robots" , "robot","amazonaws","clients.your-server"

    );
  // See if one of the identifiers is in the UA string.
  foreach ($bot_identifiers as $identifier) {
    if (strpos($user_agent, strtolower($identifier)) !== FALSE) {
      return TRUE;
    }
  }

}

$crawler = smart_ip_detect_crawler() ;

$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$ip=get_ip();
$bots=strtolower('abacho|Qwantify|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|voilaBot|googlebot|\-google|googleusercontent|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|Zeus|Gecko');


if ( preg_match('/'.$bots.'/i', strtolower($hostname) ))
  {$crawler = TRUE ;}

  if(!empty($_SERVER['HTTP_FROM'])){
if ( preg_match('/'.$bots.'/i',  strtolower($_SERVER['HTTP_FROM'])))
  {$crawler = TRUE ;}
}

// si crawler le faire attendre
if ( $crawler === true ) {
    sleep(5);
}


if($_GET['erreur']==404 && $crawler == true ){
    
  header("Status: ".http_response_code()."", false, http_response_code());
   
 header("HTTP/1.0 404 Not Found", false, 404);

 

exit;

}
//
if($_GET['erreur'] == 403 || $crawler==true){

  header("Status: ".http_response_code()."", false, http_response_code());

header("HTTP/1.1 403 Forbidden" );
//die;
}


if($_GET['erreur']!=403 && $crawler==false){
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  //header("HTTP/1.1 404 Forbidden" );

$envoi = 'webmaster@vote.site';

$email_sujet = 'Erreur '.$_GET['erreur'].' sur le site';

$email_message = 'Bonjour. Une erreur '.$_GET['erreur'].' viens de se produire sur le site web que vous gérez.'."\r\n";
$email_message .= 'Erreur: '.$ere.' '."\r\n";
$email_message .= 'Voici des informations sur ce site:'."\r\n";
$email_message .= 'Heure: '.date("d/m/Y H:i")."\r\n";
$email_message .= 'Page concernée: '.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].' '."\r\n";
$email_message .= 'Page détectée: '.$_SERVER['PHP_SELF'].' ou '.$_SERVER['SCRIPT_NAME'].' '."\r\n";
$email_message .= 'Methode: '.$_SERVER['REQUEST_METHOD'].' '."\r\n";
$email_message .= 'LANGUAGE: '.$_SERVER["HTTP_ACCEPT_LANGUAGE"].' '."\r\n";
if(isset($_SERVER['HTTP_REFERER'])){$email_message .= 'Page précédente: '.$_SERVER['HTTP_REFERER'].' '."\r\n";}
$email_message .= 'Adresse IP du visiteur: '.$_SERVER['REMOTE_ADDR'].''."\r\n";

$email_message .= 'Hostname: '.$hostname.' '."\r\n";
$email_message .= 'Adresse IP du serveur: '.$_SERVER['SERVER_ADDR'].' '."\r\n";
if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$email_message .= 'Adresse IP du proxy: '.$_SERVER['HTTP_X_FORWARDED_FOR'].' '."\r\n";}
if(isset($_SERVER['HTTP_CLIENT_IP'])){$email_message .= 'Adresse IP du reso: '.$_SERVER['HTTP_CLIENT_IP'].' '."\r\n";}
$email_message .= 'User agent: '.$_SERVER['HTTP_USER_AGENT'].' '."\r\n";

 $email_message=utf8_decode($email_message);
//echo $email_message;
@mail($envoi, $email_sujet, $email_message, $envoi);
header("HTTP/1.1 403 Forbidden" );
//die;
}

if ($_GET['erreur']== 500 || $_SERVER['PHP_SELF'] != '/index.php' || $_SERVER['SCRIPT_NAME'] != '/index.php')
{

header("Status: ".http_response_code()."", false, http_response_code());
$vue = new Vue('erreur');
$vue->getErreur($ere);

}else {

header("Status: ".http_response_code()."", false, http_response_code());
$vue = new Vue('erreur');
$vue->getErreur($ere);
}


//var_dump($_SERVER['PHP_SELF']);
