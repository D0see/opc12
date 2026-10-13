# OPC12

Application Symfony pour gérer les utilisateurs, les conseils du mois et les relevés météorologiques en fonction du code postal.

## Description

Ce projet est une API REST développée avec Symfony 7.4. Elle permet :

- de créer et gérer des utilisateurs ;
- de récupérer la météo du jour pour un code postal donné via l’API Weatherbit ;
- de gérer des conseils (tips) associés à des mois spécifiques ;

## Stack technique

- PHP 8.2
- Symfony 7.4
- Doctrine ORM
- Lexik JWT Authentication Bundle
- Symfony Security
- Symfony Validator / Serializer

## Prérequis

- PHP 8.2+
- Composer
- Base de données configurée
- Clés JWT générées localement

## Installation

```bash
composer install
```

Créer puis configurer votre fichier `.env.local` avec la base de données et les variables JWT :

```env
DATABASE_URL=
JWT_SECRET_KEY=
JWT_PUBLIC_KEY=
JWT_PASSPHRASE=
JWT_EXPIRATION_TIME=
WEATHER_BIT_API_KEY=
WEATHER_BIT_API_BASE_URL=https://api.weatherbit.io/v2.0
```

Générer les clés JWT :

```bash
mkdir -p config/jwt
php bin/console lexik:jwt:generate-keypair
```

Créer les tables et lancer les migrations :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Charger les fixtures si besoin :

```bash
php bin/console doctrine:fixtures:load
```

## Authentification

L’API utilise le système JWT de Symfony.

### Login

```http
POST /api/auth
```

Le token obtenu doit être envoyé dans le header :

```http
Authorization: Bearer <token>
```

## Endpoints principaux

### Utilisateurs

- `POST /api/user/create` : créer un utilisateur
- `PUT /api/user/{user}` : modifier un utilisateur (admin)
- `DELETE /api/user/{user}` : supprimer un utilisateur (admin)

### Météo

- `GET /api/weather-mesurement` : météo pour le code postal de l’utilisateur connecté
- `GET /api/weather-mesurement/{postalCode}` : météo pour un code postal donné

### Conseils

- `GET /api/tip/` : conseils du mois en cours
- `GET /api/tip/month/{monthNum}` : conseils pour un mois donné
- `POST /api/tip` : créer un conseil (admin)
- `PUT /api/tip/{tip}` : modifier un conseil (admin)
- `DELETE /api/tip/{tip}` : supprimer un conseil (admin)

## Sécurité

Le projet inclut une sécurisation par JWT et des restrictions selon les rôles utilisateur.

- les routes de connexion et de création de compte sont publiques ;
- les autres routes API sont protégées ;
- certaines actions demandent le rôle `ROLE_ADMIN`.

## Météo et intégration Weatherbit

La partie météo du projet est intégrée à l’API Weatherbit. Le service dédié envoie une requête pour le code postal donné et récupère la température actuelle pour le pays correspondant (France par défaut pour ce projet).

Les variables d’environnement nécessaires sont :

- `WEATHER_BIT_API_KEY`
- `WEATHER_BIT_API_BASE_URL`

Les données météo sont ensuite mises en cache et stockées dans la base de données pour éviter de refaire des appels inutiles.

## Développement

Ce projet est pensé comme une API backend légère et évolutive, avec une séparation claire entre contrôleurs, services, entités et DTO.

## Licence

Projet sous licence propriétaire.
