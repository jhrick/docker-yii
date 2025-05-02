#!/bin/bash

WEBROOT="/var/www/html/WebRoot"
SRC_DIR="$WEBROOT/src"
YIIC="$WEBROOT/vendor/yiisoft/yii/framework/yiic.php"

cd "$WEBROOT"

if [ ! -f "$COMPOSER_JSON" ]; then
  echo "➡️ Creating composer.json..."
  cat <<EOF > "$COMPOSER_JSON"
{
    "require": {
        "yiisoft/yii": "1.1.22"
    }
}
EOF

  echo "➡️ Installing composer deps..."
  cd /var/www/html/WebRoot && composer install --no-interaction --prefer-dist
fi

if [ ! -d "$SRC_DIR" ]; then
  echo "➡️ Creating Yii project..."
  yes | php "$YIIC" webapp "$SRC_DIR"
  echo "✅ Created at $SRC_DIR"
fi

