<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link media="screen" rel="stylesheet" href="../css/index.css">
    <title>Login Page</title>
</head>

<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/header.php'; ?>
    <nav class="nav">
        <?php echo $navList; ?>
    </nav>
    <main>
        <section>
            <h1>Sign In</h1>
            <?php

            if (isset($_SESSION['login-message'])) {
                echo $_SESSION['login-message'];
            }
            ?>
            <form class="form-login" method="post" action="/accounts/index.php">
                <label for="clientEmail">Email</label>
                <input name="clientEmail" id="clientEmail" type="email" required>
                <label id="clientPassword" for="clientPassword">Password</label>
                <input name="clientPassword" id="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" type="password" required>
                <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capitol letter and 1 special character.</span>
                <button class="btn-signin" name="action" value="login">Sign In</button>
                <a href='./index.php?action=registration'>Not a member yet?</a>
            </form>
        </section>
    </main>


    <?php include $_SERVER['DOCUMENT_ROOT'] . '/common/footer.php'; ?>
</body>