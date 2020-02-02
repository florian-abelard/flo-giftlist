# fl0 - gift list

## Démarrage

### Pré-requis

* docker
* docker-compose (version 3)

### Mise en place de l'environnement

```bash
# Récupération des sources github
git clone https://github.com/florian-abelard/flo-giftlist.git

# Initialisation du projet
make init

# Démarrer les containers docker
make up

# Créer et alimenter la base de données
make db-init

# Afficher toutes les commandes disponibles
make
```

Accès interface sur `http://localhost:8080`

Accès adminer sur `http://localhost:8081`
