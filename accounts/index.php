<?php


session_start();
//This is the accounts controller 
require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../library/functions.php';
require_once '../model/reviews-model.php';

$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = createNavList($classifications);

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
    case 'register':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));


        // Check for existing email duplication
        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $_SESSION['reg-message']  = '<p class="alert">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        //validate email and password
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['reg-message'] = '<p >Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit;
        }
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            setcookie('lastname', $clientLastname, strtotime('+1 year'), '/');
            setcookie('email', $clientEmail, strtotime('+1 year'), '/');

            $_SESSION['login-message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            header('Location: /accounts/?action=login-page');
            exit;
        } else {
            $_SESSION['reg-message'] = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }



    case 'login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $_SESSION['login-message']  = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $_SESSION['login-message'] = '<p class="alert">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        if (isset($_SESSION['loggedin'])) {
            include '../index.php';
        }

        $_SESSION['loggedin'] = true;
        // A valid user exists, log them in flag
        //if session removed then user is logged out. 
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view

        header('location: /accounts/index.php?action=viewAdmin');
        exit;
        break;

    case 'logout':
        $_SESSION = array();
        session_destroy();
        header('Location: /index.php');

    case 'login-page':
        unset($_SESSION["login-message"]);
        include '../view/login.php';
        exit;

    case 'registration':
        include '../view/registration.php';
        break;

    case 'viewAdmin':
        $clientId = $_SESSION['clientData']['clientId'];
        $reviews = getReviewClient($clientId);
        $reviewDisplay = buildReviewAdmin($reviews);  

        include '../view/admin.php';
        unset($_SESSION["update-message"]);
        unset($_SESSION["passMessage"]);
        break;

    case 'update-view':
        include '../view/client-update.php';
        break;

    case 'accountUpdate':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));

        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT));

        // Check for existing email duplication
        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail) {
            $_SESSION['update-message']  = '<p class="alert">That email address already exists. Try a different email.</p>';
            include '../view/client-update.php';
            exit;
        }

        //check email validation.
        $clientEmail = checkEmail($clientEmail);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $_SESSION['update-message'] = '<p class="alert">Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit;
        }

        $updateSuccess = accountUpdate($clientFirstname, $clientLastname, $clientEmail, $clientId);

        if ($updateSuccess === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            setcookie('lastname', $clientLastname, strtotime('+1 year'), '/');
            setcookie('email', $clientEmail, strtotime('+1 year'), '/');

            $_SESSION['admin-message'] = "<p class='notice'>Thanks for registering $clientFirstname. Please use your email and password to login. </p>";
            $clientData = getClientWithId($clientId);
            $_SESSION['clientData'] = $clientData;
            include '../view/admin.php';
            break;
        } else {
            $_SESSION['admin-message'] = "<p class='alert'>Sorry $clientFirstname, but the update failed. Please try again.</p>";
            include '../view/admin.php';
            break;
        }



    case 'changePassword':
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_VALIDATE_INT));

        if (empty($clientPassword)) {
            $_SESSION['passMessage'] = '<p class="alert">Please provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit;
        }

        $passwordCheck = checkPassword($clientPassword);

        if (empty($passwordCheck)) {
            $_SESSION['passMessage']  = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/client-update.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $outcome = passwordUpdate($hashedPassword, $clientId);

        if ($outcome === 1) {
            $_SESSION['admin-message'] = "<p class='notice'> Congratualations. You password had been updated. </p>";
            include '../view/admin.php';
            exit;
        } else {
            $_SESSION['admin-message'] = "<p class='alert'>Sorry, but the update failed. Please try again.</p>";
            include '../view/admin.php';
            exit;
        }




    default:
}
