# Projet symfony tu préfères
initialisation du Projet
--------------------------

cd sf_lp2018/tp/

- créer une base de donnée mysql propre au projet

*installation des dépendances*
- composer install


*création des tables*
- php bin/cosole doctrine:schema:update --dump-sql
- php bin/cosole doctrine:schema:update --force

*créer un utilisateur*
il est possible de créer un utilisateur de deux manières:
- **via register:** 127.0.0.1:8000/register
- **en ligne de commande:** php bin/console fos:user:create admin admin@admin.com password
- :warning: **Upgrade l'utilisateur:** php bin/console fos:user:promote admin ROLE_SUPER_ADMIN :warning: (nécessaire pour que le lien d'accès à la partie admin soit visible dans le menu)

**note:** *la gestion des rôle n'étant pas évalué, toutes personnes peut accéder à l'administration une fois enregistré*



" Cahier des charges"
5 pages
-------------------
*Homepage avec :*

:heavy_check_mark: **3 points** une section "Tu préfères" avec deux choix cliquables random (sans notion de catégories) au clic on comptabilise le vote et on renvoie vers la Homepage avec de nouveaux choix avec un message "Votre vote a bien été pris en compte"

:heavy_check_mark: **3 points** un panneau de login (si déjà loggé on affiche le pseudo et un bouton de déconnexion et ses 5 derniers votes)

:heavy_check_mark: **3 points** les 10 derniers votes de tout le monde

:heavy_exclamation_mark: **note:** *en cas d'utilisateur non connecté, la mention annonyme est affiché en face du vote* :heavy_exclamation_mark:


:heavy_check_mark: **Présentation :** **1 point** avec un texte lorem non dynamique

:heavy_check_mark: **Recherche :** **3 points** Recherche dans les news

:heavy_check_mark: **News :** **3 points** page de news avec détails (avec slug dans l'url et non id) et bouton retour

:heavy_check_mark: **Tops par catégories :**

:heavy_check_mark:   **3 points** Reprendre la liste des catégories et afficher le vainqueur de la catégorie.

:heavy_check_mark:   **3 points** Au clic sur une catégorie on a accès (toujours avec un slug et non id) au top par catégorie : une section "Tu préfères" avec deux choix randoms mais de la catégorie sélectionnée.

:heavy_exclamation_mark: **note:** *mention spéciale à celui là qui était bien chaud :clap:, de base j'étais parti sur une fonction getNbVotes() dans un item avec un lifeCycleCallBack en PreUpdate avec un changement de timestamp pour faire proc l'update, mais irrécupérable par le repository...(car pas un champ de BDD)*
*Complication aussi pour twig de récupérer et trier une fois les item récupéré* :confused:
*Du coup j'ai créer un champ nbVote en BDD qui change avec un preUpdate (c'est fonctionnel),* **mais je suis intéressé de savoir s'il y avait une solution plus astucieuse pour contourner ces difficultés** (:email: ou :octocat: si oui :pray:) :heavy_exclamation_mark:

:heavy_check_mark: Les urls devront être SEO friendly et sans GET parameters.

:heavy_exclamation_mark: **note :** *les articles et catégories utilisent des slugs mais je ne l'ai pas utilisé pour les item car peu utile* :heavy_exclamation_mark:


Bon courage pour les corrections et désolé du retard :persevere:
