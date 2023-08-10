<?php
if ($_SESSION['clientData']) {
    $client = $_SESSION['clientData'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>client update</title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main class="update-container">
        <div>
            <h1>Manage Account</h1>
            <h2>Acount Update</h2>

            <?php
            if (isset($_SESSION['update-message'])) {
                echo $_SESSION['update-message'];
            }
            ?>

            <form class="form-registration" method="post" action="/phpmotors/accounts/index.php?action=accountUpdate">
                <label for="clientFirstname">First Name</label>
                <input name="clientFirstname" id="clientFirstname" type="text" <?php
                                                                                echo "value='$client[clientFirstname]'";
                                                                                ?> required>
                <label for="clientLastname">Last Name</label>
                <input name="clientLastname" id="clientLastname" type="text" <?php
                                                                                echo "value='$client[clientLastname]'";
                                                                                ?> required>
                <label for="clientEmail">Email Address</label>
                <input name="clientEmail" id="clientEmail" type="email" <?php
                                                                        echo "value='$client[clientEmail]'";
                                                                        ?> required>
                <input type="hidden" name="clientId" <?php
                                                        echo "value='$client[clientId]'";
                                                        ?>>
                <button class="btn" name="action" value="update">Update</button>
            </form>

            <h2>Update Password</h2>
            <p class="alert">
                <?php
                if (isset($_SESSION['passMessage'])) {
                    echo $_SESSION["passMessage"];
                }
                ?>
            </p>
            <form class="form-registration" method="post" action="/phpmotors/accounts/index.php?action=changePassword">
                <p>Passwords must be at least 8 characters and contain at least 1 number, 1 capitol letter and 1 special character.</p>
                <p>* Entering a new password will change the current one.</p>
                <label for="clientPassword">Password</label>
                <input name="clientPassword" id="clientPassword" type="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                <input type="hidden" name="clientId" <?php
                                                        echo "value='$client[clientId]'";
                                                        ?>>
                <button class="btn" name="action" value="changePassword">Update Password</button>
            </form>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>

</body>

</html>