<?php
if (!$_SESSION['loggedin']) {
    header('Location: /phpmotors/accounts/?action=login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>Admin</title>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1><?php echo $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'];  ?></h1>
            <?php
            if (isset($_SESSION['admin-message'])) {
                echo $_SESSION['admin-message'];
            }
            ?>
            <p>You are logged in.</p>
            <ul class="admin-section">
                <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname'];  ?></li>
                <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
                <li>Email: <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
            </ul>
            <h1>Account Managment</h1>
            <p>Use this link to update account information</p>
            <p><a href="/phpmotors/accounts/index.php?action=update-view">Update Account Information</a></p>

            <?php if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<h1>Inventory Managment</h1>
                <p>Use this link to manage inventory.</p>";
                echo "<p><a href='/phpmotors/vehicles/index.php'>Vehicle Managment</a></p>";
            } ?>

            <?php
            echo $reviewDisplay;
            ?>

        </section>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>