<?php
if (!$_SESSION['loggedin'] && !$_SESSION['clientData']['clientLevel']) {
    header('Location: /index.php');
} elseif ($_SESSION['clientData']['clientLevel'] < 2) {
    header('Location: /index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>Add Car Classification</title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1>Add Car Classification</h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action="/vehicles/index.php" method="post">
                <label for="classificationName">Classification Name</label>
                <input id="classificationName" name="classificationName" type="text" pattern="^.{1,30}$" required>
                <button class="btn" name="action" type="submit" name="submit" value="addClassification">Add Classification</button>
                <span>Classification name is limited to 30 characters</span>
            </form>
        </section>
    </main>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</body>