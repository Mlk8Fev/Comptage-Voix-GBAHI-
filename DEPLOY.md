# Guide de Déploiement sur Hostinger via Git

## Méthode 1 : Via GitHub/GitLab (Recommandé)

### 1. Créer un dépôt sur GitHub/GitLab
1. Allez sur GitHub.com ou GitLab.com
2. Créez un nouveau dépôt (privé de préférence)
3. Notez l'URL du dépôt

### 2. Pousser votre code
```bash
git remote add origin https://github.com/votre-username/votre-repo.git
git branch -M main
git push -u origin main
```

### 3. Sur Hostinger (hPanel)
1. Allez dans "Git" ou "Git Version Control"
2. Cliquez sur "Créer un dépôt"
3. Sélectionnez votre dépôt GitHub/GitLab
4. Choisissez le dossier de destination (ex: `public_html`)
5. Cliquez sur "Cloner"

### 4. Configuration après clonage
Dans le terminal SSH de Hostinger :

```bash
cd public_html
composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=UserSeeder
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

## Méthode 2 : Git direct sur Hostinger

### 1. Initialiser Git sur Hostinger
Dans le terminal SSH :

```bash
cd ~/domains/votre-domaine.com/public_html
git init
git remote add origin https://github.com/votre-username/votre-repo.git
git pull origin main
```

### 2. Configuration
```bash
composer install --optimize-autoloader --no-dev
cp .env.example .env
# Éditez .env avec vos paramètres de base de données
php artisan key:generate
php artisan migrate --force
chmod -R 775 storage bootstrap/cache
```

## Mise à jour automatique (Optionnel)

Créez un script de déploiement sur Hostinger :

```bash
#!/bin/bash
cd ~/domains/votre-domaine.com/public_html
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Important
- Ne jamais commiter le fichier `.env`
- Toujours utiliser `--no-dev` en production
- Vérifier les permissions des dossiers `storage/` et `bootstrap/cache/`

