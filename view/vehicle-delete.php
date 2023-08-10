<?php

if (!$_SESSION['loggedin'] && !$_SESSION['clientData']['clientLevel']) {
    header('Location: /phpmotors/index.php');
} elseif ($_SESSION['clientData']['clientLevel'] < 2) {
    header('Location: /phpmotors/index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>
        <?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "Delete $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            echo "Delete $invMake $invModel";
        } ?>
    </title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1>
                <?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                    echo "Delete $invInfo[invMake] $invInfo[invModel]";
                } elseif (isset($invMake) && isset($invModel)) {
                    echo "Delete $invMake $invModel";
                } ?>
            </h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <p>*Note: All fields are required</p>
            <form class="vehicle-form" action="/phpmotors/vehicles/index.php" method="post">
                <label for="invMake">Vehicle Make</label>
                <input type="text" name="invMake" id="invMake" readonly <?php if (isset($invMake)) {
                                                                            echo "value='$invMake'";
                                                                        } elseif (isset($invInfo['invMake'])) {
                                                                            echo "value='$invInfo[invMake]'";
                                                                        } ?>>

                <label for="invModel">Vehicle Model</label>
                <input type="text" name="invModel" id="invModel" readonly <?php if (isset($invModel)) {
                                                                                echo "value='$invModel'";
                                                                            } elseif (isset($invInfo['invModel'])) {
                                                                                echo "value='$invInfo[invModel]'";
                                                                            } ?>>

                <label for="invDescription">Vehicle Description</label>
                <textarea name="invDescription" id="invDescription" rows="4" cols="50"><?php if (isset($invDescription)) {
                                                                                            echo $invDescription;
                                                                                        } elseif (isset($invInfo['invDescription'])) {
                                                                                            echo $invInfo['invDescription'];
                                                                                        } ?>
                </textarea>

                <button class="btn" name="action" type="submit" value="deleteVehicle">Delete Vehicle</button>
                <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                                echo $invInfo['invId'];
                                                            } ?>">
            </form>

        </section>
    </main>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>