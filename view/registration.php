<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>Registration Page</title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1>Register</h1>

            <?php
            if (isset($_SESSION['reg-message'])) {
                echo $_SESSION['reg-message'] ;
            }
            ?>
            <form class="form-registration" method="post" action="/accounts/index.php">
                <label for="clientFirstname">First Name</label>
                <input name="clientFirstname" id="clientFirstname" type="text" <?php 
                if (isset($clientFirstname)) { 
                    echo "value='$clientFirstname'";
                } ?> required>
                <label for="clientLastname">Last Name</label>
                <input name="clientLastname" id="clientLastname" type="text" <?php 
                if (isset($clientLastname)) { 
                    echo "value='$clientLastname'";
                } ?> required>
                <label for="clientEmail">Email Address</label>
                <input name="clientEmail" id="clientEmail" type="email" placeholder="Enter a valid email address" <?php 
                if (isset($clientEmail)) { 
                    echo "value='$clientEmail'";
                } ?> required>
                <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capitol letter and 1 special character.</span>
                <label id="clientPassword" for="clientPassword">Password</label>
                <input name="clientPassword" id="clientPassword" type="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                required>
                <button class="btn-pwd">Show Password</button>
                <input class="btn-reg" type="submit" name="submit" id="regbtn" value="Register">
                <input type="hidden" name="action" value="register">
            </form>
        </section>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</body>