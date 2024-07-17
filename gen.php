<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <title>OrangeXarot's Wallpapers Collection</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        @import url("https://www.nerdfonts.com/assets/css/webfont.css");

        body {
            font-family: "Rubik", sans-serif;
            background-color: #1d1a21;
            color: #fff;
            margin: 50px;
            font-size: 30px;
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
            border: 3px solid #845EC2;
            border-radius: 20px;
            transition: border-color 0.2s ease-in-out;
            display: none;
        }

        .image-category:hover {
            border-color: #b8a4dd;
        }

        .image-category:hover .image-container {
            border-color: #b8a4dd;
        }

        .image-category:hover .category-title {
            color: #b8a4dd;
        }

        .image-container {
            padding: 20px;
            border-top: 3px solid #845EC2;
            display: none;
            text-align: center;
            background-color: rgba(132, 94, 194, 0.06);
            border-radius: 0 0 20px 20px;
            transition: border-color 0.2s ease-in-out
        }

        .image-category img {
            border-radius: 10px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            transform: scale(1);
        }

        .image-category img:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px 5px #845EC2;
        }

        .category-title {
            font-size: 40px;
            margin: 10px 0;
            margin-top: 20px;
            color: #845EC2;
            padding: 20px;
            transition: color 0.2s ease-in-out;
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
            backdrop-filter: blur(3px);
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
            padding: 10px 20px;
            margin-top: auto;
            height: fit-content;
            background-color: #fff;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
        }


        .file-info {
            color: #fff;
            font-size: 1.2em;
            text-shadow: 2px 2px 4px #000;
        }

        .file-up {
            width: 90%;
            display: flex;
            justify-content: space-between;
            flex-direction: row;
            margin-bottom: 20px;
        }

        .file-name {
            font-weight: bold;
        }

        .stats {
            opacity: 0.6;
            font-size: 20px;
            margin-top: 50px;
            font-style: italic;
        }


        .full-screen-image-bigger {
            position: fixed;
            width: 100%;
            height: auto;
        }

        .full-screen-image-bogger {
            position: fixed;
            width: auto;
            height: 100%;
        }

        .full-screen-image-begger {
            position: fixed;
            width: 100%;
            height: 100%;
        }

        .display-mode {
            position: fixed;
            bottom: 20px;
            background-color: rgba(0, 0, 0, 0.38);
            padding: 10px 20px;
            opacity: 0;
            border-radius: 10px;
            backdrop-filter: blur(20px);
        }
    </style>
</head>
<body>

<h1>Welcome to the <a class="orange" href="https://orangexarot.github.io/">OrangeXarot</a>'s Wallpapers Collection</h1>
<p class="info">Live, Laugh, Lemonade.</p>

<p class="loading">Please Wait, Loading Images...</p>
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

$pccounter = 0;

$phcounter = 0;

if (count($imagesByFolder) > 0) {
    // Loop through the folders and display images under each folder
    foreach ($imagesByFolder as $folder => $images) {
        $folder = str_replace("Wallpapers/", "", $folder);
        $folder = str_replace("/", " > ", $folder);
        echo '<div class="image-category">';
        if(str_starts_with($folder, "Computer"))
            echo '<div class="category-title"><i class="nf nf-oct-device_desktop"></i> ' . htmlspecialchars($folder) . '</div>';
        else if(str_starts_with($folder, "Phone"))
            echo '<div class="category-title"><i class="nf nf-cod-device_mobile"></i> ' . htmlspecialchars($folder) . '</div>';
        echo '<div class="image-container">';
        foreach ($images as $image) {

            if(str_starts_with($folder, "Computer")) $pccounter++;
            else if(str_starts_with($folder, "Phone")) $phcounter++;

            $fileSize = filesize($image); // File size in bytes
            $fileSizeFormatted = number_format($fileSize / (1024 * 1024), 2) . ' MB';
            $imageSize = getimagesize($image); // Get image dimensions
            $imageWidth = $imageSize[0]; // Image width
            $imageHeight = $imageSize[1]; // Image height
            echo '<div style="margin: 10px; display: inline-block; text-align: center;">';
            echo '<img src="' . $image . '" alt="' . basename($image) . '" style="max-width: 300px; max-height: 300px;" class="thumbnail" data-width="' . $imageWidth . '" data-height="' . $imageHeight . '" data-size="' . $fileSizeFormatted . '">';

            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No images found in the directory '$rootDir'.";
}

echo '<div class="stats">Computer Wallpapers: <span class="countuppc">'.$pccounter.'</span><br />Phone Wallpapers: <span class="countupph">'.$phcounter.'</span></div>';
?>

<div class="full-screen-overlay" id="overlay">
    <span class="close-button" id="closeButton"></span>
    <div class="file-up">
    <div class="file-info">
        <div class="file-name" id="fileName"></div>
        <div id="fileSize"></div>
        <div id="fileDimensions"></div>
    </div>
        <a id="downloadButton" class="download-button" href="" download>Download</a>
    </div>
    <img onclick="bigger(true)" id="fullScreenImage" class="full-screen-image" src="" alt="Full Screen Image">
    <div class="display-mode"></div>
</div>

<script>

    let biggerCounter = 0;

    let countuppc;
    let maxCount;
    let countupph;
    let maxCountph;

    function bigger(increment) {
        const fullScreenImage = document.getElementById('fullScreenImage');
        const fileUp = document.querySelector(".file-up");
        const displayMode = document.querySelector(".display-mode");
        if(increment)
            biggerCounter = (biggerCounter + 1) % 4;

        switch(biggerCounter) {
            case 0:
                fullScreenImage.classList.add("full-screen-image");
                fullScreenImage.classList.remove("full-screen-image-bigger");
                fullScreenImage.classList.remove("full-screen-image-bogger");
                fullScreenImage.classList.remove("full-screen-image-begger");
                fileUp.style.display = "flex";
                displayMode.innerText = "";
                displayMode.style.opacity = 0;
                break;
            case 1:
                fullScreenImage.classList.remove("full-screen-image");
                fullScreenImage.classList.add("full-screen-image-bigger");
                fullScreenImage.classList.remove("full-screen-image-bogger");
                fullScreenImage.classList.remove("full-screen-image-begger");
                fileUp.style.display = "none";
                displayMode.innerText = "Display Mode: PC";
                displayMode.style.opacity = 1;
                break;
            case 2:
                fullScreenImage.classList.remove("full-screen-image");
                fullScreenImage.classList.remove("full-screen-image-bigger");
                fullScreenImage.classList.add("full-screen-image-bogger");
                fullScreenImage.classList.remove("full-screen-image-begger");
                fileUp.style.display = "none";
                displayMode.innerText = "Display Mode: Phone";
                displayMode.style.opacity = 1;
                break;
            case 3:
                fullScreenImage.classList.remove("full-screen-image");
                fullScreenImage.classList.remove("full-screen-image-bigger");
                fullScreenImage.classList.remove("full-screen-image-bogger");
                fullScreenImage.classList.add("full-screen-image-begger");
                fileUp.style.display = "none";
                displayMode.innerText = "Display Mode: Stretched";
                displayMode.style.opacity = 1;
                break;
        }

    }


    window.onload = () => {
        let counterpc = 0;
        let counterph = 0;
        const interval = 20;

        const intervalId = setInterval(() => {
            countuppc.innerText = counterpc;
            counterpc++;
            if (counterpc > maxCount) {
                clearInterval(intervalId);
            }
        }, interval);


        const intervalIdph = setInterval(() => {
            countupph.innerText = counterph;
            counterph++;
            if (counterph > maxCountph) {
                clearInterval(intervalIdph);
            }
        }, interval);

        let categories = document.querySelectorAll(".image-category")
        categories.forEach(function (category) {
            category.style.display = "block";
        })

        document.querySelector(".loading").style.display = "none";
    };

    document.addEventListener('DOMContentLoaded', () => {
        countuppc = document.querySelector(".countuppc");
        maxCount = countuppc.innerText;
        countupph = document.querySelector(".countupph");
        maxCountph = countupph.innerText;

        countuppc.innerText = "0";
        countupph.innerText = "0";
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
                document.body.style.overflow = "hidden";
                bigger(false);
            });
        });

        closeButton.addEventListener('click', () => {
            overlay.style.display = 'none';
            document.body.style.overflow = "";
            biggerCounter = 0;
        });

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.display = 'none';
                document.body.style.overflow = "";
                biggerCounter = 0;
            }
        });
    });


</script>

</body>
</html>