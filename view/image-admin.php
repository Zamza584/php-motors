<?php
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
    <title>Image Managment</title>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <div>
            <h1>Image Management</h1>
            <p>Welcome to the image management page. Please choose one of the options below.</p>
            <h2>Add New Vehicle Image</h2>
            <?php
            if (isset($message)) {
                echo $message;
            } ?>
            <form class="image-admin-form" action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
                <label for="invItem">Vehicle</label>
                <?php echo $prodSelect; ?>
                <fieldset>
                    <label>Is this the main image for the vehicle?</label>
                    <div class="radio-btn">
                        <label for="priYes" class="pImage">Yes</label>
                        <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
                        <label for="priNo" class="pImage">No</label>
                        <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
                    </div>
                </fieldset>
                <label>Upload Image:</label>
                <label for="file-upload" class="custom-file-upload">Browse</label>
                <input id="file-upload" type="file" class="file" name="file1">

                <input type="submit" class="regbtn" value="Upload">
                <input type="hidden" name="action" value="upload">
            </form>
            <hr>
            <h2>Existing Images</h2>
            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?php
            if (isset($imageDisplay)) {
                echo $imageDisplay;
            } ?>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>

</body>

</html>
<?php unset($_SESSION['message']); ?>