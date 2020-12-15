# QCM sous symfony 4 trave personnel :)

# Conditions requises

## PHP >= 7.2
## composer

# Usage

1. Fork ce projet
2. git clone https://github.com/[votre_username]/qcm.git
3. [optionel] : 
   - git checkout -b feature/votre-branch
4. composer install
5. configure votre .env
6. mise à jour base de données [deux choix de commande possible]
   - php bin/console bin/console doctrine:schema:update --force
   - symfony console doctrine:schema:update --force 
7. charger base de données pour tester [deux choix de commande possible]
   - php bin/console doctrine:fixtures:load
   - symfony console bin/console doctrine:fixtures:load

# Compte user par defaut
   [admin]
   		- email 	: arbandry@gmail.com
   		- password 	: arbandry@gmail.com
   [user]
   		- email 	: user@user.com
   		- password 	: user@user.com
