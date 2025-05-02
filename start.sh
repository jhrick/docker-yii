#!/bin/bash

set -e  # stop if script failed

# === SETTINGS ===
YII_DIR="./api"
CONTAINER_NAME="yii"
IMAGE_NAME="php:7.3-apache"

echo "➡️ Get permissions to root..."
sudo chmod -R 777 ./
sudo chgrp -R www-data ./
sudo chmod -R g+rw ./

# === Check docker container ===
if docker ps -a --format '{{.Names}}' | grep -q "^${CONTAINER_NAME}$"; then
  echo "✅ Container '${CONTAINER_NAME}' founded. Starting..."
  
  docker start "$CONTAINER_NAME"
  
  echo "➡️ Executing inital setup (composer)..."
  docker exec "$CONTAINER_NAME" bash /usr/local/bin/init-composer.sh

  echo "➡️ Entering the container..."
  docker exec -it "$CONTAINER_NAME" bash
else
  echo "🚀 Creating new container ('$CONTAINER_NAME') with image '$IMAGE_NAME'..."
  docker run \
    --name "$CONTAINER_NAME" \
    -v "$YII_DIR":/var/www/html/WebRoot \
    -p 8080:80 \
    -it "$IMAGE_NAME" \
    bash
fi
