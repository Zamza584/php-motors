<?php

session_start();

require_once '../model/main-model.php';
require_once '../library/connections.php';
require_once '../library/functions.php';
require_once '../model/vehicles-model.php';
require_once '../model/uploads-model.php';
require_once '../model/reviews-model.php';

$classifications = getClassifications();

$navList = createNavList($classifications);

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
    case 'classification-page':
        include '../view/add-classification.php';
        break;

    case 'addClassification':
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (empty($classificationName)) {
            $message = "<p class='alert-message'>Please provide information for all empty form fields.</p>";
            include '../view/add-classification.php';
            exit;
        }

        $checkName = checkName($classificationName);

        if (empty($checkName)) {
            $message = "<p class='alert-message'>Only 30 characters is allowed.</p>";
            include '../view/add-classification.php';
            exit;
        }

        $regOutcome = regClassification($classificationName);

        if ($regOutcome === 1) {
            $message = "<p class='alert-message'>You just registered $classificationName.</p>";
            header("Location: /phpmotors/vehicles/index.php");
            exit;
        } else {
            $message = "<p class='alert-message'>Sorry $classificationName, but we couldn't add the classification at this moment.</p>";
            include '../view/add-classification.php';
            exit;
        }


    case 'classificationList':
        include '../view/add-vehicle.php';
        break;

    case 'addVehicle':

        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = filter_input(INPUT_POST, 'classificationId');

        if (
            empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)
        ) {

            $message = "<p class='alert-message'>Please provide information for all empty form fields.</p>";
            include '../view/add-vehicle.php';
            exit;
        }

        $regOutcome = regVehicle(
            $invMake,
            $invModel,
            $invDescription,
            $invImage,
            $invThumbnail,
            $invPrice,
            $invStock,
            $invColor,
            $classificationId
        );

        if ($regOutcome === 1) {
            $message = "<p class='alert-message'>Congratulations you just registered a $invMake $invModel.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p class='alert-message'>Sorry but we couldn't add the vehicle at this moment.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;


    case 'mod':
        //view to be able to access the updates view
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);


        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p>Please complete all information for the new item! Double check the classification of the item.</p>';
            include '../view/new-item.php';
            exit;
        }
        $updateResult = updateVehicle(
            $invMake,
            $invModel,
            $invDescription,
            $invImage,
            $invThumbnail,
            $invPrice,
            $invStock,
            $invColor,
            $classificationId,
            $invId
        );
        if ($updateResult) {
            $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Error. The update was not successful.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }

        include '../view/vehicle-update.php';
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;

    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);


        if ($deleteResult) {
            $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
            deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }

        include '../view/vehicle-update.php';
        break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $vehicles = getVehiclesByClassification($classificationName);

        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }

        include '../view/classification.php';
        break;

    case 'vehicleInfo':
        $invId = filter_input(INPUT_GET, 'vehicleId', FILTER_VALIDATE_INT);
        $invItem = getInvItemInfo($invId);
        $imageArray = getThumbnailPath($invId);
        $vehicleReviews = getReviewInv($invId);

        if (!count($invItem)) {
            $message = "<p class='notice'>Sorry, no vehicles could be found.</p>";
            include '../view/classification.php';
        } else {
            $vehicleDisplayInfo = buildVehicleInfo($invItem);
            $vehicleThumbnailInfo = imagesThumbnail($imageArray);
        }

        if (count($vehicleReviews) > 0) {
            $vehicleReviewInfo = buildVehicleReview($vehicleReviews);
        } 

        include '../view/vehicle-detail.php';
        break;

    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-man.php';
        break;
}
