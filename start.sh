#!/bin/bash

set -e  # stop if script failed

YII_DIR="./api"
CONTAINER_NAME="yii"
IMAGE_NAME="php:7.3-apache"

echo "📂 Creating directories..."
mkdir -p "$YII_DIR"

echo "🛠 Setting host permissions..."
chown -R "${UID:-1000}:${GID:-1000}" "$YII_DIR"
chmod -R 775 "$YII_DIR"

if docker ps -a --format '{{.Names}}' | grep -q "^${CONTAINER_NAME}$"; then
  echo "✅ Container '${CONTAINER_NAME}' found. Starting..."
  
  docker start "$CONTAINER_NAME"
 
  echo "➡️ Executing inital setup (composer)..."
  docker exec "$CONTAINER_NAME" bash /usr/local/bin/init-composer.sh
  
  echo "➡️ Entering the container..."
  docker exec -it "$CONTAINER_NAME" bash
else
  echo "🚀 Creating new container ('$CONTAINER_NAME')..."
  docker compose up -d

  echo "➡️ Executing initial setup (composer)..."
  docker exec "$CONTAINER_NAME" bash /usr/local/bin/init-composer.sh

  echo "➡️ Entering the container..."
  docker exec -it "$CONTAINER_NAME" bash
fi
