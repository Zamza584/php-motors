<?php

//functions used in login view

function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

function createNavList($carclassifications)
{
    //Function creates navigation menu using data from car classifications found in database. 
    $navList = "<ul class='nav-container'>";
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($carclassifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

function checkName($classificationName)
{
    $pattern = "/^.{0,30}$/";
    return preg_match($pattern, $classificationName);
}

function buildClassificationList($classifications)
{
    // Build the classifications select list 
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}
/* * ********************************
*  Functions for Review Display
* ********************************* */

function buildReviewAdmin($reviews)
{
    $rd = '<h2>Reviews Made</h2>';
    $rd .= '<div class="adminReviewContainer">';
    foreach ($reviews as $review) {
        $rd .= "<div class='admin-review'>";
        $rd .= "<p><b>Review:</b> $review[reviewText]</p>";
        $rd .= "<p><b>Date of Review:</b> $review[reviewDate]</p>";
        $rd .= "<p><b>For:</b> $review[invMake] $review[invModel]</p>";
        $rd .= "<div class='review-btn'>
        <a class='btn' href='../reviews/?action=viewEdit&reviewId=$review[reviewId]'>Update</a>
        <a class='btn' href='../reviews/?action=viewDelete&reviewId=$review[reviewId]'>Delete</a>  
        </div> ";
        $rd .= "</div>";
    }
    $rd .= '</div>';

    return $rd;
}

function buildReviewUpdate($review)
{
    $date = date_create($review['reviewDate']);
    $rd = "<form action='../reviews/index.php' method='POST'>
                <h2>$review[invMake] $review[invModel] Review</h2>
                <p>Reviewed on " . date_format($date, "d F, Y H:ia") . "</p> 
                <p><b>Review Text</b></p>
                <div><textarea name='reviewText' id='review' cols='40' rows='10'>$review[reviewText]</textarea></div>
                <button class='btn' name='action' value='update' type='submit'>Update</button>               
                <input type='hidden' name='reviewId' value='$review[reviewId]' id='reviewId'>
            </form>";
    return $rd;
}

function buildReviewDelete($review)
{
    $rd = "<form action='../reviews/index.php' method='POST'>
                   <h2>Delete Confirmation</h2>
                   <span>*Remember that your review can't be undone after deletion</span>
                   <div><textarea name='reviewText' id='review' cols='40' rows='10' readonly>$review[reviewText]</textarea></div>
                   <button class='btn' name='action' value='delete' type='submit'>Delete</button>               
                   <input type='hidden' name='reviewId' value='$review[reviewId]' id='reviewId'>
           </form>";
    return $rd;
}


function buildVehicleReview($vehicleReviews)
{
    $rd = '<div class="vehicle-reviews-container">';
    foreach ($vehicleReviews as $review) {
        $date = date_create($review['reviewDate']);
        $rd .= "<div class='vehicle-reviews'>";
        $rd .= "<p class='review-text'>$review[reviewText]</p>";
        $rd .= "<p>by " . substr($review['clientFirstname'], 0, 1) . " $review[clientLastname]</p>";
        $rd .= "<p>wrote on " . date_format($date, "d l, Y H:ia") . "</p>";
        $rd .= "</div>";
    }
    $rd .= '</div>';
    return $rd;
}

/* * ********************************
*  Functions for Vehicle Display
* ********************************* */

function buildVehiclesDisplay($vehicles)
{
    //display vehicles list when clicked on a classification nav link. 
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
        $dv .= '<li>';
        $dv .= "<a href='/phpmotors/vehicles/?action=vehicleInfo&vehicleId=" . urlencode($vehicle["invId"]) . "'><img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
        $dv .= '<hr>';
        $dv .= "<h2><a href='/phpmotors/vehicles/?action=vehicleInfo&vehicleId=" . urlencode($vehicle["invId"]) . "'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
        $dv .= "<span> $" . number_format($vehicle["invPrice"]) . "</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleInfo($vehicle)
{
    //used in information page for individual vehicle.
    $display = "<h1 id='vehicle-title'>$vehicle[invMake] $vehicle[invModel]</h1>";
    $display .= "<div id='vehicle-info'>";
    $display .= "<div><img src='$vehicle[imgPath]' alt='image of $vehicle[invMake] $vehicle[invModel]'></div>";
    $display .= "<div>";
    $display .= "<h2>Price</h2>";
    $display .= "<p>$" . number_format($vehicle["invPrice"]) . "</p>";
    $display .= "<h2>Description</h2>
    <p>$vehicle[invDescription]</p>";
    $display .= "<p><b>Current Stock:</b> $vehicle[invStock]</p>";
    $display .= "<p><b>Color:</b> $vehicle[invColor]</p>";
    $display .= "</div>";
    $display .= "</div>";
    return $display;
}

function imagesThumbnail($imageArray)
{
    $id = '<ul id="thumbnail-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= '<div class=tn-image-container>';
        $id .= "<img src='$image[imgPath]' alt='$image[invMake] $image[invModel] thumbnail'>";
        $id .= '</div>';
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}


function buildImageDisplay($imageArray)
{
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
        $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

function buildVehiclesSelect($vehicles)
{
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
        $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}


/* * ********************************
*  Functions for working with images
* ********************************* */

function makeThumbnailName($image)
{
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

function uploadFile($name)
{
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        $source = $_FILES[$name]['tmp_name'];
        $target = $image_dir_path . '/' . $filename;
        move_uploaded_file($source, $target);
        processImage($image_dir_path, $filename);
        $filepath = $image_dir . '/' . $filename;
        return $filepath;
    }
}


function processImage($dir, $filename)
{
    $dir = $dir . '/';

    $image_path = $dir . $filename;
    $image_path_tn = $dir . makeThumbnailName($filename);

    resizeImage($image_path, $image_path_tn, 200, 200);
    resizeImage($image_path, $image_path, 500, 500);
}

function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{

    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    }

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        $image_to_file($new_image, $new_image_path);
        imagedestroy($new_image);
    } else {
        $image_to_file($old_image, $new_image_path);
    }
    imagedestroy($old_image);
}
