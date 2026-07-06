#!/bin/bash
# ⚠️  Reset de la base de données locale

echo "Reset de la base de données..."
docker compose down
docker volume rm wakatta_database_data
docker compose up --wait
docker compose exec php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec php bin/console doctrine:fixtures:load --no-interaction
echo "Terminé !"