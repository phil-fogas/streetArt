# street Art
sites sur le street Art projet de fin de formation,

qui sera déjà hébergée sur la-passsion.fr/streetArt/,
pour volée de ces propres aile.

Site pour référencer les streets Art,
cet art urbain issu du mouvement artistique contemporain développé à la fin du siècle dernier,
cet art qui se retrouve dans nos rues, sur nos murs.
Il se présente sous diverses formes :graffiti, pochoir, collage, sculpture, fresque…

Les hommes ont toujours écrit sur les murs.
Que ce soit au temps des hommes des cavernes,
ou encore à l’Antiquité à travers les fresques,
les hommes ne peuvent s’empêcher d’écrire leur histoire sur les murs.

---La page suggestion---
les suggestions des œuvres pourra se faire anonymement ou pas (si on est inscrit),
puis elles seront soumises aux votes des membres inscrits,
une fois qu’elle aura reçu 5 avis positifs,
la fiche du streetArt sera visible par tous le monde.

les adresses elles sont récupérées sois manuellement avec suggestion automatique «merci api-adresse.data.gouv.fr» avec une api en json,
sois par géolocalisation avec récupération de l’adresse avec "api-adresse.data.gouv.fr reverse».

---La page galerie---
les recherches des œuvres se font soit par adresse inscrit sur la fiche ou par sa catégorie

Les fiches des streets peuvent être appelées sois par numéro,
soit par leur non, soit par street_'numéro'

---La page plan---
sois dans un rayon autour d’une position GPS par géolocalisation ou d’une adresse saisie manuellement et récupération de la position GPS de la rue avec une api .
le calcul des distances se fait dans le SQL.

 attention les streets entrer dans la base son basé sur Lyon,
si vous voulez les voir par géolocalisation entrée une adresse sur Lyon,
«exemple: place bellecour Lyon»

---La gestion compte---
Les internautes pourront s’inscrit avec un mail valide
«par vérification du pattern dans le formulaire puis en php email passer dans le filter_var pour assurée que le mail est conforme puis un petit regard s’il y a un serveur mail et lier au domaine»,
un pseudo et un mot de passe.

S’il oublie leur mot de passe,
il pourra le modifier par la page «mot de passs oublier»
ou il devra obligatoirement mettre leur e-mail,
leur pseudo et le nouveau mot de passe.

bien sur le mot de passe est haché et crypter avec password_hash.

---mini jeux---
Le jeu en JS ,canvas et sur le principe du casse brick mais là il faut effacer les taches,
la taille et nombres de celle-ci  et aléatoire,
le street Art du fond et pris aléatoirement dans la base,
une gestion des partis gagnée et perdu permet d’ajuster le niveau au fur et a mesure,
les données sont  stockées en localStorage.

---gestion des images---
Les images son redimensionné, compressé avant téléchargement a un maximum de width ou height  de 1200 Px ,
avec prévisualisation de l’image.
Ou si par hasard le JS est pas activée, la photo est redimensionnée en php après upload.
Donc l’image est mise dans un canvas aux dimensions estimer puis converti avec toDataURL
puis envoyer en post, récupérer sur le serveur en Php pour reconstituaient de l’image avec base64_decode.
Pour pourvoir optimiser la place sur le serveur et affichage pour les voir sur smartphone.
Et bien sur quand la fiche est détruite la photo aussi.

Le mode dark est manuel ou automatique selon heure.

---les fiches ---
les votes sont réservés au membre inscrit, comme pour les commentaires,
une fois vote on ne peut pas revote,

les fiches streets sont visibles celons le niveau de droit administration de l’internaute,

1-l'anonyme (non inscrit) ne verra que les œuvres référencés, visible et pourra en suggérer ,

2-le membre inscrit verra tous les œuvres, visible et en cours de la validation et pourra les commenter,
il pourra supprimer ces commentaires, modifier ces fiches, voter et suggère de nouvelle fiche cette fois a son nom.

3-le modérateur verra tous les œuvres et commenter,
pourra en plus modifier toutes les fiches streets ou les supprimer,
supprimer les commentaires,

4-l'admin voir toutes les œuvres même celle archivée et non visible,
ajouter et supprimer des catégories,
supprimer les membres, basculer un membre sois en modérateur ou inverse,
lire les messages envoyer sur la page contact,
supprimer les commentaires,
modifier et archiver ou détruire les fiches street,

mot de passe pour teste les modes

pseudo :loulou mdp: 3wa rôle: admin
pseudo :tata mdp: 3wa rôle: modérateur
pseudo :toto mdp: 3wa rôle: membre

***dossier app**
les fichiers de conection a la base
config.json -- mot de passe de la base
Database.php -- gestion des requete
function.php --- gestion des function en php

**css**
iconfont.min.css -- pour les icons qui vient de iconfont
normalize.min.css -- heu pour normaliser les navigateur
style.css -- tous le css du projet

**database**
le dump
le pdf des table avec les contraintes

**fonts**
bakerStreet --pour l'ecriture
icofont --pour les icones je crois

**img ***
les images qui sont telecharger et vu sur les fiches

**js**
ping.js -- pour le mini jeux de casse brick
street.js --pour tous les reste du site

**models**
tous les commande de sql

**pic**
les images et les icon utiliser pour le designe du site

**templates**
je crois que ces les templates en .phtml
de chaque pages

**uploads**
dossier temporaire le tepms de la redimention des images
