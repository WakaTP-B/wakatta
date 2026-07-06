#!/bin/bash
# ⚠️  SCRIPT DE DÉVELOPPEMENT UNIQUEMENT — NE JAMAIS EXÉCUTER EN PRODUCTION
# Ce script supprime intégralement la base de données locale et la recrée avec les fixtures.

echo "Reset complet de la base de données..."
docker compose down -v
docker compose up --wait
docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec php bin/console doctrine:fixtures:load --no-interaction
echo "Terminé !"
