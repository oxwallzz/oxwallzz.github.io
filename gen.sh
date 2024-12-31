#!/bin/bash


echo "Generating low res images"
./lowres.sh

echo "Making zip file..."
rm Wallpapers.zip
zip -r Wallpapers.zip Wallpapers/Computer Wallpapers/Phone

cp index.html index_original.html

echo "Starting php server..."
php -S localhost:8000 > /dev/null 2>&1 & sleep 1

curl -s localhost:8000/gen.php > index.html
echo "Changed index.html"

echo "Diff between original and updated index.html:"
colordiff -u index_original.html index.html

PID=$(pgrep -f "php -S localhost:8000")
kill $PID
echo "Killed php server"

rm index_original.html
