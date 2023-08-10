<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="/phpmotors/css/index.css">
    <title><?php echo $invItem['invMake'] . " " . $invItem['invModel']; ?> vehicles | PHP Motors, Inc.</title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <?php if (isset($message)) {
            echo $message;
        }
        ?>
        <p class="notice">Vehicle reviews can be seen at the bottom of the page</p>
        <div class="vehicle-detail-container">
            <?php if (isset($vehicleDisplayInfo)) {
                echo $vehicleDisplayInfo;
            }
            ?>

            <h2 id="tn-head">Vehicles thumbnails</h2>

            <?php if (isset($vehicleThumbnailInfo)) {
                echo $vehicleThumbnailInfo;
            }
            ?>
        </div>
        <div>
            <h1>Customer Reviews</h1>
            <?php

            if (!isset($_SESSION['loggedin'])) {
                echo "
                <p>A review can be added by logging in.</p> 
                <a href='../view/login.php'><button class='btn'>Login</button></a>";
            } else {
                $client = $_SESSION['clientData'];
                echo "
                <form action='../reviews/index.php' method='POST'>
                    <label for='review'><b> " . substr($client['clientFirstname'], 0, 1) . " $client[clientLastname]</b></label>
                    <div><textarea name='reviewText' id='review' cols='50' rows='10'></textarea></div>
                    <button class='btn' name='action' value='add' type='submit'>Submit Review</button>               
                    <input type='hidden' name='invId' value='$invItem[invId]' id='invId'>
                    <input type='hidden' name='clientId' value='$client[clientId]' id='clientId'>        
                </form>";
            }

            echo "<h2>Reviews</h2>";
            if (isset($vehicleReviewInfo)){
                echo $vehicleReviewInfo; 
            } else {
                echo "<p class='notice'>Currently there are no reviews to display</p>";
            }
            
            ?>
        
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html>