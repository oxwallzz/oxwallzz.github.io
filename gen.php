<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <title>Image Gallery</title>
    <style>
        body {
            font-family: "Rubik", sans-serif;
            background-color: #1d1a21;
            color: #fff;
            margin: 50px;
        }


        .info {
            margin-bottom: 50px;
        }

        .orange {
            color: #ff4f00;
        }

        .image-category {
            cursor: pointer;
            margin: 10px 0;
        }

        .image-container {
            display: none;
        }

        .image-category img {
            border-radius: 5px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            transform: scale(1);
        }

        .image-category img:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px 5px #845EC2;
        }

        .category-title {
            font-size: 1.5em;
            margin: 10px 0;
            margin-top: 20px;
            color: #845EC2;
        }

        .category-title:hover {
            color: #b8a4dd;
        }

        .full-screen-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #1d1a21cc;

            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1000;
            backdrop-filter: blur(1px);
        }

        .full-screen-image {
            max-width: 90%;
            max-height: 80%;
            box-shadow: 0 0 10px 5px #845EC2;
            animation: wow 5s infinite;
        }

        @keyframes wow {
            50% {box-shadow: 0 0 15px 10px #845EC2;}
        }

        .download-button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #fff;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
        }

        .close-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 12px;
            background-color: #fff;
            color: #000;
            border-radius: 50%;
            font-size: 1.5em;
            cursor: pointer;
        }

        .file-info {
            color: #fff;
            margin-bottom: 20px;
            font-size: 1.2em;
        }

        .file-name {
            font-weight: bold;
        }

    </style>
</head>
<body>

<h1>Welcome to the <span class="orange">OrangeXarot</span>'s Wallpapers Collection</h1>
<p class="info">Live, Laugh, Lemonade.</p>

<?php
// Directory path
$rootDir = 'Wallpapers';

// Function to recursively get images from a directory and categorize them by folders
function getImagesByFolder($dir, &$imagesByFolder) {
    // Check if the directory exists
    if (is_dir($dir)) {
        // Open the directory
        if ($dh = opendir($dir)) {
            // Loop through the files in the directory
            while (($file = readdir($dh)) !== false) {
                // Skip current and parent directory entries
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $filePath = $dir . '/' . $file;
                // If it's a directory, recursively get images from it
                if (is_dir($filePath)) {
                    getImagesByFolder($filePath, $imagesByFolder);
                } else {
                    // Check if the file is an image
                    if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)) {
                        $imagesByFolder[$dir][] = $filePath;
                    }
                }
            }
            // Close the directory handle
            closedir($dh);
        }
    }
}

// Array to hold images categorized by folder
$imagesByFolder = [];

// Get all images from the root directory and its subdirectories
getImagesByFolder($rootDir, $imagesByFolder);

// Sort the folders by their path names
ksort($imagesByFolder);


foreach ($imagesByFolder as &$images) {
    sort($images);
}
unset($images);

// Check if there are any images
if (count($imagesByFolder) > 0) {
    // Loop through the folders and display images under each folder
    foreach ($imagesByFolder as $folder => $images) {
        $folder = str_replace("Wallpapers/", "", $folder);
        $folder = str_replace("/", " > ", $folder);
        echo '<div class="image-category">';
        echo '<div class="category-title">' . htmlspecialchars($folder) . '</div>';
        echo '<div class="image-container">';
        foreach ($images as $image) {
            $fileSize = filesize($image); // File size in bytes
            $fileSizeFormatted = number_format($fileSize / (1024 * 1024), 2) . ' MB';
            $imageSize = getimagesize($image); // Get image dimensions
            $imageWidth = $imageSize[0]; // Image width
            $imageHeight = $imageSize[1]; // Image height
            echo '<div style="margin: 10px; display: inline-block; text-align: center;">';
            echo '<img src="' . $image . '" alt="' . basename($image) . '" style="max-width: 200px; max-height: 200px;" class="thumbnail" data-width="' . $imageWidth . '" data-height="' . $imageHeight . '" data-size="' . $fileSizeFormatted . '">';
            echo '<br>' . htmlspecialchars(basename($image));
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No images found in the directory '$rootDir'.";
}
?>

<div class="full-screen-overlay" id="overlay">
    <span class="close-button" id="closeButton">&times;</span>
    <div class="file-info">
        <div class="file-name" id="fileName"></div>
        <div id="fileSize"></div>
        <div id="fileDimensions"></div>
    </div>
    <img id="fullScreenImage" class="full-screen-image" src="" alt="Full Screen Image">
    <a id="downloadButton" class="download-button" href="" download>Download</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const categories = document.querySelectorAll('.category-title');
        categories.forEach(category => {
            category.addEventListener('click', () => {
                const imageContainer = category.nextElementSibling;
                if (imageContainer.style.display === 'none' || imageContainer.style.display === '') {
                    imageContainer.style.display = 'block';
                } else {
                    imageContainer.style.display = 'none';
                }
            });
        });

        const thumbnails = document.querySelectorAll('.thumbnail');
        const overlay = document.getElementById('overlay');
        const fullScreenImage = document.getElementById('fullScreenImage');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileDimensions = document.getElementById('fileDimensions');
        const downloadButton = document.getElementById('downloadButton');
        const closeButton = document.getElementById('closeButton');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', (e) => {
                const img = e.target;
                fullScreenImage.src = img.src;
                fileName.textContent = img.alt;
                fileSize.textContent = 'Size: ' + img.dataset.size;
                fileDimensions.textContent = 'Dimensions: ' + img.dataset.width + 'x' + img.dataset.height;
                downloadButton.href = img.src;
                overlay.style.display = 'flex';
            });
        });

        closeButton.addEventListener('click', () => {
            overlay.style.display = 'none';
        });

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>

</body>
</html>
