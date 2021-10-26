# Projet-Personnage-Licence-3-
Projet Techno Web, Projet en PHP 

Sujet : “Création d’exposition à partir de bibliothèque photo”.

Objectif: réaliser un site web contenant une banque d’images, et permettant de pouvoir créer des expositions à partir de la banque d’images contenue sur le site.
Ce site web devrait pouvoir permettre à un utilisateur de s’inscrire puis de se connecter. 
Il peut créer ses propres expositions, et que celle-ci soit visible par tous les autres utilisateurs. 
Tout d’abord nous qllonf implementer une interface php permettant la navigation entre plusieurs pages.
Ensuite implémenter un script javascript pour la création d’exposition notamment avec l'utilisation de drag and drop (glisser déposer). 
Et pour finir, communiquer avec une base de données sql pour pouvoir enregistrer les comptes des utilisateurs et aussi les expositions créées.

Architecture 
  -Package
  -Modèle MVCR

Interface
  -Présentation des pages
  -Quelques vues du site

Fonctionnalités implémentées
  -Création d’exposition
  -Affichage d’exposition
  -Inscription / Connexion / Gestion compte
  -Gestion des bases de données

Dossier db
    Le dossier db contient tous les fichiers sql permettant l’initialisation de la base donnée.
Dossier images
    Le dossier images contient toutes les images qui pourront être utilisées lors de la création d’une exposition et lors de l’affichage de celle-ci.

Dossier javascript
    Le dossier javascript contient tout le script nécessaire pour permettre le drag and drop et le traitement des images côté client.
    
Dossier src
    Le dossier src va quant à lui contenir tout le code php permettant la gestion des différentes vues dans le site mais aussi s’occuper de toutes les interactions avec le serveur pour ce qui est de l’envoi, la réception et la gestion des données en base de données. Il est lui même décomposé en plusieurs sous dossiers, basé sur l'architecture MVCR en php que nous détaillerons un peu plus bas.

Dossier style
    Et pour finir le dossier style qui contient les différents fichiers css pour ajouter un peu de design au site web et aussi un dossier image pour l’image de la bannière.

Modèle MVCR 
    Implementation du modek MVCR (Modèle, Vue, Contrôleur, Routeur). 
Le modèle MVCR est constitué d’un routeur qui sera le point d’entrée de l’application, donc le fichier principal qui sera appelé par l’internaute. Le travail du routeur va être d’analyser le contenu des requêtes HTTP pour ensuite rediriger l’internaute vers le contrôleur ou la vue en fonction de ses choix.
Ensuite nous avons le contrôleur qui effectue toutes les actions demandées tout en mettant à jour le modèle et en faisant le lien entre le modèle et la vue sans passer par le routeur.
Le modèle est censé contenir le coeur de l’application c’est à dire toutes les données, les algorithmes, les traitements, les bases de données. Dans notre cas le modèle s'occupe surtout de gérer toutes les requêtes vers la base de données grâce à des requêtes SQL. Le modèle ne connaît ni le routeur, ni le contrôler, ni la vue.
Pour finir la vue qui correspond à toute la partie affichage. La vue utilise l’état du modèle pour générer du HTML en fonction des demandes du contrôleur. La vue ne manipule pas le modèle et ne connais pas le contrôleur et ne fait qu'exécuter ses demandes, en revanche la vue a besoin de savoir comment le routeur interprète les requêtes HTTP donc pour cela elle va interroger le routeur qui va lui transmettre ces informations.
