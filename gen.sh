#!/bin/bash


echo "Generating low res images"
./lowres.sh
echo "Done"

echo "Making zip file..."
before=$(du -h Wallpapers.zip | awk '{print $1}')
rm Wallpapers.zip
zip -r Wallpapers.zip Wallpapers/Computer Wallpapers/Phone
after=$(du -h Wallpapers.zip | awk '{print $1}')
echo "Done"

php gen.php > index.html
echo "Changed index.html"
echo

echo "Wallpapers.zip  before: ${before} after: ${after}"
git status -s
