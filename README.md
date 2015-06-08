# BeJoe

## Description du projet
BeJoe est un réseau social mettant en avant la recommandation entre amis
 
## Initialisation

Le projet utilise une stack technique s'appuyant sur des containers [Docker](https://www.docker.com/), 
orchestrés avec [Docker Compose](https://docs.docker.com/compose/).

_Pour Mac OS, il est nécessaire d'installer [Boot2Docker](http://boot2docker.io/) et [https://github.com/brikis98/docker-osx-dev]()_

### Lancement des containers
 
```shell
$ docker-compose up -d
```
_(le premier lancement peut être long à cause du téléchargement des images des containers)_

### Makefile

Un fichier `Makefile` a été créé pour utiliser indépendament les containters orchestrés par Docker.
Il s'utilise de la façon suivante
```shell
$ make <command>
# exemple : make start lance le container d'application et ses serverus liés (serveur noe4j, nginx et php) 
```

Les commandes définies dans le makefile sont : 
- *pull* : télécharge toutes les images docker nécessaires à l'application, sans instantier les containers
 
## Tests


## Documentation technique détaillée

Les chapitres suivants détaillent l'aspect technique du projet

- Stockage des données (Neo4J)
- Sécurité
- Intégration continue
