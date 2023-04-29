<?php
require_once ("db.php");
require_once ("functions.php");

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if(isset($_POST["add_user_btn"]))
{
    if(is_admin())
    {
        if($_POST['password'] !== $_POST['password1'])
        {
            echo "Passwords do not match, please try again";
        }
        else
        {
            $fn = clean_data($_POST["first_name"]);
            $ln = clean_data($_POST["last_name"]);
            $jt = clean_data($_POST["job_title"]);
            $ut = clean_data($_POST["user_type"]);
            $bd = clean_data($_POST["birthdate"]);
            $gender = clean_data($_POST["gender"]);
            $email = is_valid_email($_POST["email"]);
            if ($email)
            {
                if(!$fn || !$ln || !$jt || !$ut || !$bd || !$gender)
                {
                    echo "Missing Data, please try again";
                }
                else
                {
                    $password = clean_data($_POST["password"]);
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO `users`
                                                            (`first_name`, 
                                                             `last_name`, 
                                                             `job_title`,
                                                             `user_type_id`,                                                            
                                                             `birthdate`, 
                                                             `gender`, 
                                                             `email`,
                                                             `password`,
                                                             `added_by`,
                                                             `image`) 
                                                       VALUES 
                                                            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    if(isset($_POST["user_image"]))
                    {
                        $stmt->bind_param("sssissssis", $fn, $ln, $jt, $ut, $bd, $gender, $email, $hash,
                            $_SESSION["user_id"], $img);
                        $stmt->execute();
                    }
                    else
                    {
                        $img = null;
                        $stmt->bind_param("sssissssis", $fn, $ln, $jt, $ut, $bd, $gender, $email, $hash,
                            $_SESSION["user_id"], $img);
                        $stmt->execute();
                    }
                }
            }
            else
            {
                echo "Invalid Email, please try again";
            }
        }
        header("location: meeting.php");
    }
}
else
{
    echo"You Need to use POST to view this page";
    if(@$_SESSION["loggedin"])
    {
        header("refresh:5; url=meeting.php");
    }
    else
    {
        header("refresh:5; url=login.php");
    }
}