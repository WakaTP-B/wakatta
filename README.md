# Wakatta! わかった

Application web d'apprentissage du japonais pour débutants francophones, conçue et développée dans le cadre du titre professionnel DWWM.

4 modules d'apprentissage (QCM Vocabulaire, Hiragana Calligraphie, Hiragana Complétion, Hiragana Assemblage), un système de progression par XP, et un alphabet hiragana consultable à tout moment.

## Prérequis

- [Docker](https://www.docker.com/) et Docker Compose (inclus avec Docker Desktop)

Rien d'autre à installer : PHP, Composer et PostgreSQL tournent entièrement dans des containers.

## Installation

```bash
git clone https://github.com/WakaTP-B/wakatta.git
cd wakatta
docker compose up
```

Une fois les containers démarrés, l'application est accessible sur **https://localhost**.

Un avertissement de certificat s'affiche au premier accès : c'est normal, le certificat HTTPS est généré automatiquement par Caddy (FrankenPHP) pour le développement local, il n'est pas signé par une autorité publique.

## Scripts utiles

| Script | Rôle |
|---|---|
| `./reset-env.sh` | Réinitialisation complète de l'environnement (volumes compris) |
| `./reset-db.sh` | Réinitialisation de la base de données seule |
| `./backup-db.sh` | Export du schéma et des données pour sauvegarde |

## Stack technique

Symfony 7.4 · Twig · Stimulus & Turbo · Tailwind CSS v4 · PostgreSQL · FrankenPHP · Docker
