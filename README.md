# Site de Visionnage de Films

Ce projet est une application web développée sous Laravel 11, permettant de visionner les films disponibles via l'API de [vidsrc.to](https://vidsrc.to). Les informations des films sont récupérées à l'aide de l'API de [The Movie Database (TMDB)](https://www.themoviedb.org).

## Fonctionnalités

- **Visionnage de films** : Parcourez et visionnez les films disponibles sur l'API de vidsrc.to.
- **Informations détaillées** : Obtenez des informations complètes sur les films via l'API TMDB.
- **Authentification obligatoire** : L'accès au site nécessite une connexion utilisateur.
- **Gestion des utilisateurs** : Utilisez des commandes artisan pour gérer les utilisateurs.

## Prérequis

- PHP 8.2 ou plus récent
- Composer
- Laravel 11
- Une clé API pour TMDB
- Une clé API pour vidsrc.to

## Installation

1. Clonez le dépôt :

    ```bash
    git clone https://github.com/votre-utilisateur/votre-repo.git
    cd votre-repo
    ```

2. Installez les dépendances :

    ```bash
    composer install
    ```

3. Copiez le fichier `.env.example` en `.env` et configurez vos variables d'environnement, y compris les clés API :

    ```bash
    cp .env.example .env
    ```

4. Générez la clé d'application :

    ```bash
    php artisan key:generate
    ```

5. Configurez votre base de données dans le fichier `.env` et exécutez les migrations :

    ```bash
    php artisan migrate
    ```

6. Lancez le serveur de développement :

    ```bash
    php artisan serve
    ```

## Gestion des Utilisateurs

Pour gérer les utilisateurs, vous pouvez utiliser les commandes artisan suivantes :

- **Créer un utilisateur** :

    ```bash
    php artisan user:create "nom de l'utilisateur" "email" "mot de passe"
    ```

- **Supprimer un utilisateur** :

    ```bash
    php artisan user:delete "id à supprimer"
    ```

- **Modifier un utilisateur** :

    ```bash
    php artisan user:update "id à modifier" "nouveau nom d'utilisateur" "nouvel email" "nouveau mot de passe"
    ```

- **Lister tous les utilisateurs** :

    ```bash
    php artisan user:list
    ```
