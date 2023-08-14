<?php

if (!$_SESSION['loggedin'] && !$_SESSION['clientData']['clientLevel']) {
    header('Location: /index.php');
} elseif ($_SESSION['clientData']['clientLevel'] < 2) {
    header('Location: /index.php');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>Vehicle Management</title>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1>Vehicle Management</h1>
            <ul class="vehicle-managment">
                <li>
                    <a href="/vehicles/index.php?action=classification-page">Add Classification</a>
                    <a href="/vehicles/index.php?action=classificationList">Add Vehicle</a>
                </li>
            </ul>
            <?php
            if (isset($message)) {
                echo $message;
            }
            if (isset($classificationList)) {
                echo '<h2>Vehicles By Classification</h2>';
                echo '<p>Choose a classification to see those vehicles</p>';
                echo $classificationList;
            }
            ?>
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>
            <table id="inventoryDisplay"></table>

        </section>
    </main>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
    <script src="../js/inventory.js"></script>
</body>

</html><?php unset($_SESSION['message']); ?>