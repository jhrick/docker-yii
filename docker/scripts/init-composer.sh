#!/bin/bash

WEBROOT="/var/www/html/WebRoot"
SRC_DIR="$WEBROOT/src"
YIIC="$WEBROOT/vendor/yiisoft/yii/framework/yiic.php"

cd "$WEBROOT"

if [ ! -f "composer.json" ]; then
  echo "➡️ Creating composer.json..."
  cat <<EOF > "composer.json"
{
    "require": {
        "yiisoft/yii": "1.1.22"
    }
}
EOF

  echo "➡️ Installing composer deps..."
  composer install --no-interaction --prefer-dist
fi

if [ ! -d "$SRC_DIR" ]; then
  echo "➡️ Creating Yii project..."
  yes | php "$YIIC" webapp "$SRC_DIR"
  echo "✅ Created at $SRC_DIR"
fi

echo "🛠 Checking permissions..."
if [ -w "$WEBROOT" ]; then
  echo "✅ Permissions OK at $WEBROOT"
else
  echo "❌ Permission issue at $WEBROOT. Ensure the host directory has correct UID/GID."
  exit 1
fi
