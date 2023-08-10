<header>
    <div class="container-header">
        <a href="/phpmotors/index.php">
            <img class="logo" src="/phpmotors/images/site/logo.png" alt="phpmotors logo">
        </a>
        <div id="my-account">
            <?php if (isset($_SESSION['clientData']['clientFirstname'])) {
                echo "<a id='welcome-message' href='/phpmotors/accounts/index.php?action=viewAdmin'><span>Welcome " . $_SESSION['clientData']['clientFirstname'] . " </span></a>
                <span>|</span>";
            } ?>
            <?php if (isset($_SESSION['loggedin'])) {
                echo "<a href='/phpmotors/accounts/index.php?action=logout'>
                    Log Out </a>";
            } else {
                echo "<a href='/phpmotors/accounts/index.php?action=login-page'>
                    My Account </a>";
            } ?>

        </div>
    </div>
</header>