# Projet 8 Formation Développeur d'application - PHP/Symfony Openclassrooms

## Guide d'installation :

1. Clonez ou télécharger le repository GitHub

- `git clone https://github.com/aurore-dw/projet-8.git`

2. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier .env

3. Dans le projet, téléchargez et installez composer
   
- `composer install`

4. Mettre en place la base de donnée
   
- `php bin/console doctrine:database:create`
- `php bin/console doctrine:migrations:migrate`
- `php bin/console doctrine:schema:update --force`

5. Implémenter les fixtures
   
- `php bin/console doctrine:fixtures:load`

6. Démarrer le serveur web local de Symfony
   
- `symfony server:start`

7. Accéder à l'application, généralement `http://localhost:8000`.
