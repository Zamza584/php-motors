<?php

session_start();
//This is the main controller 
require_once 'library/connections.php';
require_once 'model/main-model.php';
require_once 'library/functions.php';


$clientFirstname = filter_input(INPUT_POST, 'clientFirstname');

$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = createNavList($classifications);

$action = filter_input(INPUT_GET, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
}

if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {
    case 'template':
        include 'view/template.php';
        break;
    default:
        include 'view/home.php';
}
