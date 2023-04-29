<?php
require_once ("db.php");
require_once ("functions.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["update_meeting_btn"]))
{
    if (is_admin())
    {
        $files = array_filter($_FILES["meeting_attachment"]["name"]);
        $total = count($_FILES["meeting_attachment"]["name"]);
        for ($i = 0; $i < $total; $i++) {
            // Get the temp file path
            $tmp_file_path = $_FILES['meeting_attachment']['tmp_name'][$i];
            // Make sure there's a file path
            if ($tmp_file_path != "") {
                // Allow certain file formats
                $allowed_formats = array("pdf", "png", "gif", "jpeg", "jpg");
                // Set up our new file path
                $new_file_path = "../img/" . $_FILES["meeting_attachment"]["name"][$i];
                $file_name = basename($_FILES["meeting_attachment"]["name"][$i]);
                $file_type = pathinfo($new_file_path, PATHINFO_EXTENSION);
                if (in_array($file_type, $allowed_formats)) {
                    // Upload file to server
                    if (move_uploaded_file($_FILES["meeting_attachment"]["tmp_name"][$i], $new_file_path)) {
                        $stmt = $conn->prepare("INSERT INTO `meeting_attachment`
                                                        (`attachment_name`, `meeting_id`) 
                                                    VALUES
                                                        (?, ?)");
                        $stmt->bind_param("si", $file_name, $_POST["meeting_id"]);
                        $stmt->execute();
                    }
                } else {
                    $_SESSION["error"]["file_type"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload";
                    header("location:update_product.php");
                }
            }
        }

        /* OLD FILE UPLOAD ========================================================================
        // File upload path
        $file_dir = "../img/";
        $file_name = basename($_FILES["meeting_attachment"]["name"]);
        $file_path = $file_dir . $file_name;
        $file_type = pathinfo($file_path, PATHINFO_EXTENSION);
        // How the image will be saved on the database
        $file_db = "img/" . $file_name;
        // Allow certain file formats
        if ($file_type == "pdf")
        // Upload file to server
        if (move_uploaded_file($_FILES["meeting_attachment"]["tmp_name"], $file_path))
        ========================================================================================*/

        $meeting_id = $_POST["meeting_id"];
        $meeting_name = clean_data($_POST["meeting_name"]);
        $meeting_date = $_POST["meeting_date"];
        if (empty($_POST["meeting_date"])) {
            $meeting_date = null;
        }
        $meeting_current = $_POST["meeting_current"];
        $meeting_confirmed = $_POST["meeting_confirmed"];
        $update_stmt = $conn->prepare("UPDATE
                                              `meeting`
                                            SET
                                              `meeting_name` = ?,
                                              `meeting_date` = ?,
                                              `is_current` = ?,
                                              `is_confirmed` = ?
                                            WHERE
                                                meeting_id = ?");
        $update_stmt->bind_param("ssiii", $meeting_name, $meeting_date,
            $meeting_current, $meeting_confirmed, $meeting_id);
        $update_stmt->execute();
        header("location:meeting.php");
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