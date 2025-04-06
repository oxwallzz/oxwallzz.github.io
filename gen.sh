#!/bin/bash


echo "Generating low res images"
./lowres.sh
echo "Done"

echo "Making zip file..."
rm Wallpapers.zip
zip -r Wallpapers.zip Wallpapers/Computer Wallpapers/Phone
echo "Done"
cp index.html index_original.html

php gen.php > index.html
echo "Changed index.html"

echo "Diff between original and updated index.html:"
colordiff -u index_original.html index.html

rm index_original.html