3 plugins : 

Docker  
PHPDocker  
PHP remote interpreter  

Ouvrez la fenêtre des paramètres phpStorm (ctrl+alt+s ou File/Settings/…)
Allez dans l’onglet Build, execution, deployment
Cliquez sur Docker

Cliquez sur + pour ajouter une nouvelle configuration Docker et indiquer à phpStorm comment se connecter au démon Docker.
Allons maintenant dans Tools pour fournir à phpStorm les interpréteurs de docker et docker-compose

dans File/Settings…/Languages & Framework/PHP* 
Cliquez sur ... à droite de CLI Interpreter
Dans Remote sélectionnez Docker (le serveur que nous avons créé précédemment est automatiquement sélectionné)
Dans Image name sélectionnez skeleton:latest

dans File/Settings…/Languages & Framework/PHP* 
sélectionnez l’interpréteur que nous venons de créer…
Dans la partie Docker container cliquez sur les ... et mappez le répertoire skeleton avec /srv/app

Cliquez sur + puis PHP remote debug dans le select en haut
Donnez un nom à cette configuration
Cliquez sur ... afin d’ajouter un serveur de débogage

Ici, il faut mettre en nom de serveur le nom que nous avons mis dans la variable d’environnement PHP_IDE_CONFIG
Notez également qu’il faut ajouter le mapping entre notre environnement local et le container.
Sélectionnez le serveur précédemment créé et ajoutez l’IDE key PHPSTORM

en cliquant sur le bouton debug phpstorm va écouter...
Il faut ajouter un cookie xdebug PHPSTORM utiliser un plugin pour ça avec chrome :)
