<?php
require_once "db.php";
require_once "functions.php";
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>

<!Doctype html>
<html>
    <link rel="stylesheet" href="../css/Home.css">
    <link rel="stylesheet" href="../css/sign_up.css">
    <body>
        <header>
            <div class="top">
                <div id="logo">
                    <a href="login.php"><img src="../img/logoo.png"></a>
                </div>
                <label>Laptops</label>
            </div><br><br>
        </header>
        <?php
        // We make sure the user is not logged in, since this is a login page, and he can't view it while signed in
        if(!isset($_SESSION["loggedin"]) && @$_SESSION["loggedin"] !== true)
        {
        ?>
            <div id="si" class="sign" style="margin:auto">
                <form method="post" action="authentication.php">
                    <div>
                        <h1>Log into your Account</h1> <br>
                    </div>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" size="40px" class="textbox" autocomplete="username"
                               placeholder="Enter your Email" required>
                    </div>
                    <div>
                        <label for="current-password">Password</label>
                        <input type="password" name="password" size="40px" class="textbox" autocomplete="current-password"
                               placeholder="Enter your Password" id="current-password" required>
                    </div>
                    <p class="error_msg"><?php
                        // Echo errors -if any-
                        if(isset($_SESSION["error"]["login"]["email"]))
                        {
                            echo $_SESSION["error"]["login"]["email"];
                            // unset the error message so that it doesn't remain on the page
                            unset($_SESSION["error"]["login"]["email"]);
                        }
                        elseif(isset($_SESSION["error"]["login"]["user_not_found"]))
                        {
                            echo $_SESSION["error"]["login"]["user_not_found"];
                            // unset the error message so that it doesn't remain on the page
                            unset($_SESSION["error"]["login"]["user_not_found"]);
                        }
                        elseif (isset($_SESSION["error"]["login"]["not_allowed"]))
                        {
                            echo $_SESSION["error"]["login"]["not_allowed"];
                            // unset the error message so that it doesn't remain on the page
                            unset($_SESSION["error"]["login"]["not_allowed"]);
                        }
                        elseif(isset($_SESSION["error"]["login"]["password"]))
                        {
                            echo $_SESSION["error"]["login"]["password"];
                            // unset the error message so that it doesn't remain on the page
                            unset($_SESSION["error"]["login"]["password"]);
                        }
                        ?>
                    </p>
                    <br><button type="submit" id="sign_in_btn" name="sign_in_btn" class="button">Sign in</button> <br><br>
<!--                    <p>Forgot your password? <a href="" class="hyperlink">Reset Password</a> now!</p>-->
                </form>
            </div>
        <?php
        }
        else
        {
            ?>
            <p class="error_msg" style="text-align: center">
                You're already logged in, you'll be redirected in 5 seconds.
            </p><br>
            <?php
            header("refresh:5; url=meeting.php");
        }
        footer();
        ?>
    </body>
</html>
