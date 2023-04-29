<?php
require_once ("db.php");
require_once "functions.php";

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["add_meeting_btn"]))
{
    if(is_admin()):
        $stmt = $conn->prepare("SELECT * FROM meeting WHERE is_current = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0)
        {
            // Insert files into database
            $stmnt = $conn->prepare("INSERT INTO `meeting` 
                                        (`meeting_name`, `meeting_date`, `is_current`, `is_confirmed`)
                                    VALUES 
                                        (?, ?, ?, ?)");
            $meeting_name = clean_data($_POST["meeting_name"]);
            $meeting_date = clean_data($_POST["meeting_date"]);
            if (empty($_POST["meeting_date"]))
            {
                $meeting_date = null;
                $stmnt->bind_param("ssii",$meeting_name, $meeting_date,
                    $_POST["meeting_current"], $_POST["meeting_confirmed"]);
            }
            else
            {
                $stmnt->bind_param("ssii",$meeting_name, $meeting_date,
                    $_POST["meeting_current"], $_POST["meeting_confirmed"]);
            }
            $stmnt->execute();
            header("location:meeting.php");
        }
        else
        {
            $_SESSION["error"]["meeting"] = "There's already a meeting in progress, please end it before starting a new one";
            header("location:add_meeting.php");
        }
    endif;
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
/* OLD FILE UPLOAD ===============================================================================
        // File upload path
        $file_dir = "../img/";
        $file_name = basename($_FILES["meeting_attachment"]["name"]);
        $file_path = $file_dir . $file_name;
        $file_type = pathinfo($file_path, PATHINFO_EXTENSION);
        // How the image will be saved on the database
        $file_db = "img/" . $file_name;
        // Allow certain file formats
        if ($file_type == "pdf")
        {
            // Upload file to server
            if (move_uploaded_file($_FILES["meeting_attachment"]["tmp_name"], $file_path))
            {
                // Insert image file name into database
                $stmnt = $conn->prepare("INSERT INTO `meeting`
                                                    (`meeting_name`, `meeting_date`, `is_current`, `is_confirmed`,
                                                        `attachment`)
                                                VALUES
                                                    (?, ?, ?, ?, ?)");
                if (empty($_POST["meeting_date"]))
                {
                    $meeting_date = null;
                    $stmnt->bind_param("ssiis",$_POST["meeting_name"], $meeting_date,
                        $_POST["meeting_current"], $_POST["meeting_confirmed"], $file_db);
                }
                else
                {
                    $stmnt->bind_param("ssiis",$_POST["meeting_name"], $_POST["meeting_date"],
                        $_POST["meeting_current"], $_POST["meeting_confirmed"], $file_db);
                }
                $stmnt->execute();
                header("location:meeting.php");
            }
        }
        else
        {
            $_SESSION["error"]["file_type"] = "Sorry, only PDF files are allowed to be uploaded";
            header("location:add_meeting.php");
        }
===============================================================================================================*/