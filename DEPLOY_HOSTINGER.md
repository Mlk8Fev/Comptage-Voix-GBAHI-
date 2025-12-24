# Guide de Déploiement sur Hostinger - Comptage des Voix

## Informations de connexion

- **Base de données** : `u382713207_Election`
- **Utilisateur MySQL** : `u382713207_Malick`
- **Mot de passe** : `Malick@2025`
- **Dépôt Git** : `https://github.com/Mlk8Fev/Comptage-Voix-GBAHI-.git`

## Étapes de déploiement

### 1. Cloner le dépôt Git

**Dans hPanel :**
1. Allez dans "Git" ou "Git Version Control"
2. Cliquez sur "Cloner un dépôt"
3. URL : `https://github.com/Mlk8Fev/Comptage-Voix-GBAHI-.git`
4. Dossier : `public_html`
5. Cliquez sur "Cloner"

**OU via SSH :**
```bash
cd ~/domains/votre-domaine.com/public_html
git clone https://github.com/Mlk8Fev/Comptage-Voix-GBAHI-.git .
```

### 2. Créer le fichier .env

**Via File Manager :**
1. Allez dans `public_html`
2. Copiez `.env.example` vers `.env`
3. Éditez `.env` et remplacez par :

```env
APP_NAME="Comptage des Voix"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u382713207_Election
DB_USERNAME=u382713207_Malick
DB_PASSWORD=Malick@2025
```

### 3. Exécuter les commandes (via SSH ou Terminal hPanel)

```bash
cd public_html

# Installer les dépendances
composer install --optimize-autoloader --no-dev

# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate --force

# Créer les utilisateurs
php artisan db:seed --class=UserSeeder

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
chmod -R 775 storage bootstrap/cache
```

### 4. Vérifier les permissions

Assurez-vous que ces dossiers ont les bonnes permissions :
- `storage/` → 775
- `bootstrap/cache/` → 775

### 5. Tester l'application

1. Allez sur votre domaine
2. Vous devriez voir la page de connexion
3. Connectez-vous avec :
   - Email : `admin@election.com`
   - Mot de passe : `admin123`

## Mises à jour futures

Pour mettre à jour après des modifications :

```bash
cd public_html
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Comptes administrateurs créés

1. **admin@election.com** / admin123
2. **admin2@election.com** / admin123
3. **admin3@election.com** / admin123
4. **fadika.malick@election.com** / fadika123
5. **konan.delmas@election.com** / konan123
6. **gbahi.eddy@election.com** / gbahi123
7. **gbahi.yvan@election.com** / gbahi123

