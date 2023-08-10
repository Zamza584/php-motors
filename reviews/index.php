<?php
//Reviews Controller 
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../model/reviews-model.php';
require_once '../library/functions.php';


$classifications = getClassifications();
$navList = createNavList($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

$_SESSION['message'] = '';
$message = $_SESSION['message'];

switch ($action) {
    case 'add':
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT));

        if (empty($reviewText) || empty($invId) || empty($clientId)) {
            $message = "<p class='alert-message'>Please provide information for all empty form fields.</p>";
            include '../view/vehicle-detail.php';
            exit;
        }

        $rows = insertReview($reviewText, $invId, $clientId);

        if ($rows === 1) {
            $message = "<p class='notice'>Congratulations you just registered a review.</p>";
            header('location: ../vehicles/index.php?action=vehicleInfo&vehicleId='.$invId.'');
            exit;
        } else {
            $message = "<p class='alert'>An error has ocurred please try again.</p>";
            include '../vehicles/?action=vehicleInfo&vehicleId=' . $invId;
            exit;
        }

    case 'viewEdit':
        $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
        $review = getReview($reviewId); 
        $reviewDisplayUpdate = buildReviewUpdate($review);

        include '../view/reviews-update.php';
        break;

    case 'update':
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_VALIDATE_INT));
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $review = getReview($reviewId); 

        if (empty($reviewId) || empty($reviewText)) {
            $message = "<p class='alert'>Please provide information for all empty form fields.</p>";
            $reviewDisplayUpdate = buildReviewUpdate($review);
            include '../view/reviews-update.php';
            exit;
        }

        $rows = updateReview($reviewId, $reviewText);

        if ($rows === 1) {
            $_SESSION['admin-message'] = "<p class='notice'>Congratulations your review has been updated .</p>";
            header('location: ../accounts/index.php?action=viewAdmin');
            exit;
        } else {
            $_SESSION['admin-message'] = "<p class='alert'>An error has ocurred please try again.</p>";
            header('location: ../accounts/index.php?action=viewAdmin');
            exit;
        }

    case 'viewDelete':
        $reviewId = trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
        $review = getReview($reviewId); 
        $reviewDisplayDelete = buildReviewDelete($review);

        include '../view/reviews-delete.php';
        break;

    case 'delete':
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_VALIDATE_INT));
        $deleteResult = deleteReview($reviewId);

        if ($deleteResult  === 1) {
            $_SESSION['admin-message'] = "<p class='notice'>Congratulations your review has been deleted .</p>";
            header('location: ../accounts/index.php?action=viewAdmin');
            exit;
        } else {
            $_SESSION['admin-message'] = "<p class='notice'>An error has ocurred please try again.</p>";
            header('location: ../accounts/index.php?action=viewAdmin');
            exit;
        }

    default:
        include '../view/admin.php';
}
