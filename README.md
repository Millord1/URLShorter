# MyAna - URL Shortener

Un raccourcisseur d'URL sur **Laravel 12** avec **PHP 8.4**

## Fonctionnalités
- **Génération unique** : Création de liens courts et uniques en Base62 sur l'id du Link
- **Analytics** : Suivi du nombre de clics et de la dernière utilisation
- **Gestion complète** : Dashboard CRUD
- **Sécurité** : Protection par authentification (Breeze) et Soft Deletes 
- **Redirection** : Redirections gérées via un Controller dédié

## Stack Technique
- **Framework** : Laravel 12 / PHP 8.4
- **Architecture** : Repository, Services et DTO.
- **Base de données** : SQLite (configuré pour le local et les tests)
- **Frontend** : Laravel Breeze pour la base puis Blade et JQuery

## Installation
- **Docker** : Création d'un **compose.yaml** via Sail

## Tests
- **Intégration** : Tests d'intégration réalisés pour les deux Controllers et la Scheduled Command pour delete les liens inactifs
- **Unitaires** : Test unitaire pour le CodeGenerator, je n'ai pas jugé nécessaire de 'tester pour tester' étant donné que le projet embarque peu de logique métier