Copier le fichier .env (dans le teams)
Lancer Xampp (Apache et MySQL)


Ligne de commandes à lancer :

composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
composer require symfony/security-bundle
composer require --dev orm-fixtures

Lancer la base de données :
databaserestart.bat

Lancer le serveur :
symfony serve