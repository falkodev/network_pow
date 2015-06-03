# BeJoe

## Description du projet
BeJoe est un réseau social mettant en avant la recommandation entre amis
 
## Initialisation

Le projet utilise une stack technique s'appuyant sur des containers [Docker](https://www.docker.com/), 
orchestrés avec [Docker Compose](https://docs.docker.com/compose/).

_Pour Mac OS, il est nécessaire d'installer [Boot2Docker](http://boot2docker.io/) et [https://github.com/brikis98/docker-osx-dev]()_

### Lancement des containers
 
```
$ docker-compose up -d
```
_(le premier lancement peut être long à cause du téléchargement des images des containers)_
 
## Tests


## Documentation technique détaillée

Les chapitres suivants détaillent l'aspect technique du projet

- Stockage des données (Neo4J)
- Sécurité
- Intégration continue
