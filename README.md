Système de Réservation Symfony

_Fonctionnalités_

S'inscrire et se connecter
Gérer son profil
Faire des réservations avec des créneaux horaires
Admin peut gérer les utilisateurs et les réservations

_Prérequis_
PHP
Composer
Symfony CLI
MySQL
Node.js
Serveur web

\*Installation/

- Cloner le projet :
  git clone <url-du-repo>
  cd <dossier-du-projet>

- Installer les dépendances PHP :
  composer install

- Installer les dépendances JavaScript :
  npm install

- Configurer les variables d'environnement :
  Ouvrez .env.local et modifiez DATABASE_URL avec vos informations de base de données :
  DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/nom_de_la_base"

- Mettre en place la base de données :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

- Démarrer le serveur :
  symfony server:start
  Ouvrez votre navigateur et allez à http://127.0.0.1:8000

Utilisation
Profil utilisateur : /profile
Tableau de bord admin : /admin/users
