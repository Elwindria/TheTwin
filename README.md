# TheTwin - Installation locale (Symfony)

Ce document explique comment lancer le projet en local sur macOS/Linux/Windows avec Docker.

## 1. Prerequis

- PHP 8.4+
- Composer 2+
- Node.js 18+ et npm
- Docker + Docker Compose
- (Optionnel) Symfony CLI

Verification rapide:

```bash
php -v
composer -V
node -v
npm -v
docker -v
docker compose version
```

## 2. Cloner et se placer dans le projet

```bash
git clone https://github.com/Elwindria/TheTwin.git
cd TheTwin
```

## 3. Installer les dependances

Dependances PHP:

```bash
composer install
```

Dependances front:

```bash
npm install
```

## 4. Configurer l'environnement

Le projet fournit deja un fichier `.env` avec une configuration MySQL locale:

```dotenv
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
```

Vous pouvez creer un fichier `.env.local` si vous voulez surcharger certains parametres localement.

## 5. Demarrer les services Docker

Le projet utilise Docker Compose pour la base MySQL et Mailpit (SMTP local).

```bash
docker compose up -d
```

Verifier les conteneurs:

```bash
docker compose ps
```

Services exposes:

- MySQL: `127.0.0.1:3306`
- Mailpit SMTP: `127.0.0.1:1025`
- Interface web Mailpit: `http://127.0.0.1:8025`

## 6. Initialiser la base de donnees

Executer les migrations:

```bash
php bin/console doctrine:migrations:migrate
```

Si vous voulez repartir d'une base propre:

```bash
php bin/console doctrine:database:drop --force --if-exists
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Charger les fixtures (donnees de test/developpement):

```bash
php bin/console doctrine:fixtures:load
```

Note: cette commande purge la base avant de recharger les donnees.

## 7. Compiler les assets front

Pour un build ponctuel:

```bash
npm run dev
```

Pour compiler automatiquement pendant le developpement:

```bash
npm run watch
```

## 8. Lancer l'application Symfony

Option A (recommandee, avec Symfony CLI):

```bash
symfony serve -d
```

Option B (sans Symfony CLI):

```bash
php -S 127.0.0.1:8000 -t public
```

Ensuite ouvrez:

- `http://127.0.0.1:8000`

## 9. Lancer les tests

```bash
php bin/phpunit
```

## 10. Arreter l'environnement local

Arreter Docker:

```bash
docker compose down
```

Arreter et supprimer aussi les volumes (attention: supprime les donnees MySQL locales):

```bash
docker compose down -v
```

## Commandes utiles

```bash
# Vider le cache
php bin/console cache:clear

# Voir les logs Symfony
tail -f var/log/dev.log
```
