<?php

if (!$_SESSION['loggedin'] && !$_SESSION['clientData']['clientLevel']) {
    header('Location: /index.php');
} elseif ($_SESSION['clientData']['clientLevel'] < 2) {
    header('Location: /index.php');
}

$classifList = "<label for='classificationId'>Car Classifications</label>";
$classifList .= '<select name="classificationId" id="classificationId">';
$classifList .= '<option value="none" selected disabled hidden>Select an classification</option>';
foreach ($classifications as $classification) {
    $classifList .= "<option value='$classification[classificationId]'";

    if (isset($classificationId)) {
        if ($classification['classificationId'] == $classificationId) {
            $classifList .= ' selected ';
        }
    }
    $classifList .= ">$classification[classificationName]</option>";
}
$classifList .= '</select>';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>Add Vehicle</title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1>Add Vehicle</h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <p>*Note: All fields are required</p>
            <form class="vehicle-form" action="/vehicles/index.php" method="post">


                <?php echo $classifList ?>

                <label for="invMake">Make</label>
                <input name="invMake" id="invMake" type="text" required <?php if (isset($invMake)) {
                                                                            echo "value='$invMake'";
                                                                        } ?>>
                <label for="invModel">Model</label>
                <input name="invModel" id="invModel" type="text" <?php if (isset($invModel)) {
                                                                        echo "value='$invModel'";
                                                                    } ?> required>

                <label for="invDescription">Description</label>
                <textarea name="invDescription" id="invDescription" rows="4" cols="50"><?php if (isset($invDescription)) {
                                                                                            echo $invDescription;
                                                                                        } ?>
                </textarea>
                <label for="invImage">Image Path</label>
                <input name="invImage" id="invImage" value="/images/no-image.jpg" type="text" <?php if (isset($invImage)) {
                                                                                                            echo "value='$invImage'";
                                                                                                        } ?> required>
                <label for="invThumbnail">Thumbnail</label>
                <input name="invThumbnail" id="invThumbnail" type="text" value="/images/no-image.jpg" required <?php if (isset($invThumbnail)) {
                                                                                                                                echo "value='$invThumbnail'";
                                                                                                                            } ?>>
                <label for="invPrice">Price</label>
                <input name="invPrice" id="invPrice" type="number" step="0.01" <?php
                                                                                if (isset($invPrice)) {
                                                                                    echo "value='$invPrice'";
                                                                                } ?> required>
                <label for="invStock">Stock</label>
                <input name="invStock" id="invStock" type="number" <?php
                                                                    if (isset($invStock)) {
                                                                        echo "value='$invStock'";
                                                                    } ?> required>
                <label for="invColor">Color</label>
                <input name="invColor" id="invColor" type="text" <?php
                                                                    if (isset($invColor)) {
                                                                        echo "value='$invColor'";
                                                                    } ?> required>
                <button class="btn" name="action" type="submit" value="addVehicle">Add Vehicle</button>
            </form>

        </section>
    </main>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</body>