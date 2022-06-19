#/bin/bash

PROJECT_NAME=arthur
NEXT_VERSION=$1
CURRENT_VERSION=$(cat style.css | grep Version | head -1 | awk -F= "{ print $2 }" | sed 's/[Version:,\",]//g' | tr -d '[[:space:]]')

sed -i "s/Version:     $CURRENT_VERSION/Version:     $NEXT_VERSION/g" style.css
sed -i "s/$CURRENT_VERSION/$NEXT_VERSION/g" functions.php

mkdir /tmp/$PROJECT_NAME
cp -ar ./*.php screenshot.png style.css framework vendor dist config lib woocommerce templates languages /tmp/$PROJECT_NAME 2>/dev/null
cd /tmp
zip -qr /tmp/release.zip ./*.php $PROJECT_NAME
