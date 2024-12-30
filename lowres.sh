#!/bin/bash

# Directories
computer_dir="Wallpapers/Computer/"
phone_dir="Wallpapers/Phone/"
lowres_computer_dir="Wallpapers/lowres/Computer/"
lowres_phone_dir="Wallpapers/lowres/Phone/"

# Ensure lowres directories exist
mkdir -p "$lowres_computer_dir"
mkdir -p "$lowres_phone_dir"

# Resize function
resize_images() {
  source_dir="$1"
  target_dir="$2"

  for img in "$source_dir"*; do
    if [[ -f "$img" ]]; then
      filename=$(basename "$img")
      convert "$img" -resize 300 "$target_dir$filename"
      echo "Resized $img -> $target_dir$filename"
    fi
  done
}

# Resize images in each folder
resize_images "$computer_dir" "$lowres_computer_dir"
resize_images "$phone_dir" "$lowres_phone_dir"

echo "All images resized and saved in lowres directories."
