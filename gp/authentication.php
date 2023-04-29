<?php
require_once ("db.php");
require_once ("functions.php");

// start session if not started
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

// Make sure the user came here by pressing the button
if (isset($_POST["sign_in_btn"])):
    // check the email entered
    if (is_valid_email($_POST["email"]))
    {
        $email = $_POST["email"];
        $stmt = $conn->prepare("SELECT user_id, first_name, last_name, password, is_enabled, user_type_id 
                                        FROM users WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        // check if the user's email exists in database
        if ($result->num_rows === 1)
        {
            // User's email exists in the database
            // Save user's record in an associative array
            $row = $result->fetch_assoc();
            $password = $_POST["password"];
            // Check if user is allowed to log into the system
            if ($row["is_enabled"] === 1)
            {
                // User is enabled to log into the system
                // Check user's password
                if (password_verify($password, $row["password"]))
                {
                    // Change user's session id to prevent session fixation attacks
                    session_regenerate_id();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["name"] = "{$row['first_name']} {$row['last_name']}";
                    $_SESSION["user_id"] = $row["user_id"];
                    // Check if the hashed password needs to be rehashed
                    if (password_needs_rehash($row['password'], PASSWORD_DEFAULT))
                    {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $query = $conn->prepare("UPDATE users SET password=? WHERE email=?");
                        $query->bind_param("ss", $newHash, $email);
                        $query->execute();
                    }
                    // Check if user is an admin
                    if ($row["user_type_id"] === 2)
                    {
                        $_SESSION["admin"] = true;
                    }
                    // Check if user is a dean
                    elseif ($row["user_type_id"] === 3)
                    {
                        $_SESSION["dean"] = true;
                    }
                    // Unset errors regarding login -if any exists-, since user successfully signed in
                    if (isset($_SESSION["error"]["login"]))
                    {
                        unset($_SESSION["error"]["login"]);
                    }
                    // Redirect user to the next page (Meetings page)
                    header("location:meeting.php");
                }
                else
                {
                    // Password doesn't match database, but I won't let the user know for security concerns
                    $_SESSION["error"]["login"]["password"] = "Incorrect credentials, please try again";
                    header("location:login.php");
                }
            }
            else
            {
                // User is not allowed to log into the system
                $_SESSION["error"]["login"]["not_allowed"] = "You're not allowed to log into the system";
                header("location:login.php");
            }
        }
        else
        {
            // Email doesn't exist in database
            $_SESSION["error"]["login"]["user_not_found"] = "User not found, please contact system administrator";
            header("location:login.php");
        }
    }
    else
    {
        // Email doesn't meet the standards
        $_SESSION["error"]["login"]["email"] = "Incorrect email format";
        header("location:login.php");
    }
else:
    echo"You Need to use POST to view this page";
    if(@$_SESSION["loggedin"])
    {
        header("refresh:5; url=meeting.php");
    }
    else
    {
        header("refresh:5; url=login.php");
    }
endif;