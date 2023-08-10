<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="./css/index.css">
    <title>PHP Motors! / Home</title>
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section class="action">
            <h1>Welcome to PHP Motors!</h1>
            <div class="box1">
                <section>
                    <h2>DMC Delorean</h2>
                    <p>3 Cup holders Superman doors Fuzzy dice!</p>
                </section>
                <a href="./vehicles/?action=vehicleInfo&vehicleId=24"><button class="btn">Own Today</button></a>
            </div>
            <img src="/phpmotors/images/vehicles/delorean.jpg" alt="delorean car">
        </section>
        <section class="review">
            <h2>DMC Delorean Reviews</h2>
            <ul>
                <li>"So fast it's almost like traveling in time." (4/5)</li>
                <li>"Coolest ride on the road." (4/5)</li>
                <li>"I'm feeling Marty McFly!" (5/5)</li>
                <li>"The most futuristic ride of our day." (4.5/5)</li>
                <li>"80's livin and I love it!" (5/5)</li>
            </ul>
        </section>
        <section class="upgrades">
            <h2>Delorean Upgrades</h2>
            <div class="upgrades-container">
                <div>
                    <div class="image-container">
                        <img src="./images/upgrades/flux-cap.png" alt="Flux Capacitor Image">
                    </div>
                    <p><a href="/">flux Capacitor</a></p>
                </div>
                <div>
                    <div class="image-container">
                        <img src="./images/upgrades/flame.jpg" alt="Flame Decals Image">
                    </div>
                    <p><a href="/">Flame Decals</a></p>
                </div>
                <div>
                    <div class="image-container">
                        <img src="./images/upgrades/bumper_sticker.jpg" alt="bumper sticker Image">
                    </div>
                    <p><a href="/">Bumper Stickers</a></p>
                </div>
                <div>
                    <div class="image-container">
                        <img src="./images/upgrades/hub-cap.jpg" alt="Hub Caps Image">
                    </div>
                    <p><a href="/">Hub Caps</a></p>
                </div>
            </div>
        </section>

    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>

</body>

</html>