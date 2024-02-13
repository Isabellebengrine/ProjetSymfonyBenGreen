Projet développé avec Symfony 4.4.16
PHP Version 7.4.9

Installé Webpack Encore en janvier 2021 pour utiliser nouislider dans page de recherche sur le catalogue de produits (pensez à faire 'encore dev' !!!)

Attention : Work In Progress... (entraînement pour Titre Professionnel CDA
Concepteur Développeur d'Applications)
Si vous remarquez une erreur et souhaitez me faire part de critiques (constructives),
contactez-moi via Linkedin, merci!

Février 2021: corrigé Datafixtures 

**************************************************************
Instructions
**************************************************************
Pour installer les dépendances manquantes:
composer install
(pour yarn: npm install -g yarn
	puis: yarn set version berry
	puis : yarn install)
npm install

Pour créer la base de données :
php bin/console doctrine:database:create

Pour construire la bdd :
php bin/console doctrine:migrations:migrate
ou ...doctrine:schema:update --force

Pour remplir la bdd :
php bin/console doctrine:fixtures:load
(vous obtiendrez notamment 51 produits, 102 customers, 420 totalorders et 1140 orderdetails;
à vous de modifier Datafixtures>AppFixtures.php si vous le souhaitez)

