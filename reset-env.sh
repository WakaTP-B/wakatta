#!/bin/bash
# ⚠️  RESET TOTAL — supprime tout, y compris Caddy et ses certifis HTTPS
echo "Reset total de l'environnement Docker..."
docker compose down -v
docker compose up -d
echo "Correction des permissions sur les nouveaux volumes..."
docker compose run --rm --user root php chown -R 1000:1000 /data /config
docker compose restart php
docker compose up --wait
docker compose run --rm php composer install
docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec php bin/console doctrine:fixtures:load --no-interaction
echo "Terminé !"