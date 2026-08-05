#!/bin/bash
#  Sauvegarde complète de la BDD (schéma + données)

TIMESTAMP=$(date +%Y%m%d_%H%M%S)
FILENAME="backup_${TIMESTAMP}.sql"

echo "Sauvegarde de la BDD..."
docker compose exec -T database pg_dump -U wakatta wakatta > "$FILENAME"
echo "Terminé ! Sauvegarde enregistrée dans $FILENAME"