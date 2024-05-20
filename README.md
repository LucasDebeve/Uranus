# Uranus

Uranus est une api qui permet de gérer des cours en ligne.

## Installation

1. Cloner le dépôt
2. Installer les dépendances
3. Copier le fichier `.env` en `.env.local` et modifier les variables d'environnement si besoin
4. Générer la base de données
5. Lancer le serveur

## Utilisation

### Scripts

#### Générer la BD

```bash
composer run db
```

#### Lancer le serveur

```bash
composer run start
```

#### Lancer les tests CS Fixer

```bash
composer run test:cs
```

#### Corriger les erreurs de code CS Fixer

```bash
composer run fix:cs
```

#### Lancer les tests unitaires

```bash
composer run test:phpunit
```

#### Lancer tous les tests

```bash
composer run test
```
