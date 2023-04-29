<?php
require_once ("db.php");
require_once ("functions.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["add_subject_btn"]))
{
    if(is_admin())
    {
        // Adding Subject details
        $subject_name = clean_data($_POST["subject_name"]);
        $subject_details = clean_data($_POST["subject_details"]);
        $subject_type = $_POST["subject_type"];
        $comments = (empty($_POST["subject_comment"]) ? null : clean_data($_POST["subject_comment"]));
        $insert_stmt = $conn->prepare("INSERT INTO `subject`
                                            (`subject_name`, `subject_details`, `subject_type_id`, `meeting_id`, `comments`, `added_by`)
                                          VALUES
                                            (?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("ssiisi", $subject_name, $subject_details, $subject_type,
            $_POST["meeting_id"], $comments, $_SESSION["user_id"]);
        if ($insert_stmt->execute())
        {
            // Adding subject attachment
            $meeting_id = $_POST["meeting_id"];
            $stmt = $conn->prepare("SELECT max(subject_id) FROM subject WHERE meeting_id = ?");
            $stmt->bind_param("i", $meeting_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            // Attachments Upload Code
            $attachment_allowed_types = array("pdf", "png", "gif", "jpeg", "jpg");
            $uploaded_attachments = Upload("subject_attachment", "../img/", $attachment_allowed_types);
//            echo "<pre>";
//            print_r($uploaded_attachments);
//            echo "</pre>";
            if (!empty($uploaded_attachments))
            {
                foreach ($uploaded_attachments as $key => $value)
                {
                    $attachment_stmt = $conn->prepare("INSERT INTO `subject_attachment`
                                                        (`attachment_name`, `attachment_title`, `subject_id`, `added_by`)
                                                    VALUES
                                                        (?, ?, ?, ?)");
                    $attachment_stmt->bind_param("ssii", $value, $key, $row["max(subject_id)"],
                                                        $_SESSION["user_id"]);
                    $attachment_stmt->execute();
                }
            }

            // Adding picture attachment
            $pic_allowed_formats = array("png", "gif", "jpeg", "jpg");
            $uploaded_pictures = Upload("subject_picture", "../img/", $pic_allowed_formats);
//            echo "<pre>";
//            print_r($uploaded_pictures);
//            echo "</pre>";
            if (!empty($uploaded_pictures))
            {
                foreach ($uploaded_pictures as $key => $value)
                {
                    $picture_stmt = $conn->prepare("INSERT INTO `p39_subject_picture`
                                                        (`picture_name`, `picture_title`, `subject_id`, `added_by`)
                                                    VALUES
                                                        (?, ?, ?, ?)");
                    $picture_stmt->bind_param("ssii", $value, $key, $row["max(subject_id)"],
                        $_SESSION["user_id"]);
                    $picture_stmt->execute();
                }
            }
        }
    }
    header("location:meeting.php");
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

            // OLD
//            for ($i = 0; $i < $total1; $i++) {
//                // Get the temp file path
//                $tmp_file_path1 = $_FILES['subject_picture']['tmp_name'][$i];
//                // Make sure there's a file path
//                if ($tmp_file_path1 != "") {
//                    // Allow certain file formats
//                    $allowed_formats1 = array("png", "gif", "jpeg", "jpg");
//                    // Set up our new file path
//                    $new_file_path1 = "../img/" . $_FILES["subject_picture"]["name"][$i];
//                    $file_name1 = basename($_FILES["subject_picture"]["name"][$i]);
//                    $file_type1 = pathinfo($new_file_path1, PATHINFO_EXTENSION);
//                    if (in_array($file_type1, $allowed_formats1)) {
//                        // Upload file to server
//                        if (move_uploaded_file($_FILES["subject_picture"]["tmp_name"][$i], $new_file_path1)) {
//                            $attachment_stmt1 = $conn->prepare("INSERT INTO `p39_subject_picture`
//                                                        (`picture_name`, `subject_id`)
//                                                    VALUES
//                                                        (?, ?)");
//                            $attachment_stmt1->bind_param("si", $file_name1, $row["max(subject_id)"]);
//                            $attachment_stmt1->execute();
//                        }
//                    }
//                    else
//                    {
//                        $_SESSION["error"]["file_type"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload";
//                        header("location:update_product.php");
//                    }
//                }
//            }

/*
 * $_FILES Contents
 *     [subject_attachment] => Array
        (
          * FILE NAME
            [name] => Array
                (
                    [0] => Acer-final.png
                    [1] => Dell-final.png
                )
          * FILE NAME
            [full_path] => Array
                (
                    [0] => Acer-final.png
                    [1] => Dell-final.png
                )
          * FILE TYPE
            [type] => Array
                (
                    [0] => image/png
                    [1] => image/png
                )
          * FILE PATH OF XAMPP TMP FILE
            [tmp_name] => Array
                (
                    [0] => D:\xampp\tmp\php5540.tmp
                    [1] => D:\xampp\tmp\php5541.tmp
                )

            [error] => Array
                (
                    [0] => 0
                    [1] => 0
                )

            [size] => Array
                (
                    [0] => 2859
                    [1] => 4543
                )

        )

    [subject_picture] => Array
        (
            Same as above
        )
 */

// OLD ATTACHMENT CODE
//            for ($i = 0; $i < $total; $i++) {
//                // Get the temp file path
//                $tmp_file_path = $_FILES['subject_attachment']['tmp_name'][$i];
//                // Make sure there's a file path
//                if ($tmp_file_path != "") {
//                    // Allow certain file formats
//                    $allowed_formats = array("pdf", "png", "gif", "jpeg", "jpg");
//                    // Set up our new file path
//                    $new_file_path = "../img/" . $_FILES["subject_attachment"]["name"][$i];
//                    $file_name = basename($_FILES["subject_attachment"]["name"][$i]);
//                    $file_type = pathinfo($new_file_path, PATHINFO_EXTENSION);
//                    if (in_array($file_type, $allowed_formats)) {
//                        // Upload file to server
//                        if (move_uploaded_file($_FILES["subject_attachment"]["tmp_name"][$i], $new_file_path))
//                        {
//                            $attachment_stmt = $conn->prepare("INSERT INTO `subject_attachment`
//                                                        (`attachment_name`, `subject_id`)
//                                                    VALUES
//                                                        (?, ?)");
//                            $attachment_stmt->bind_param("si", $file_name, $row["max(subject_id)"]);
//                            $attachment_stmt->execute();
//                        }
//                    }
//                    else
//                    {
//                        $_SESSION["error"]["file_type"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload";
//                        header("location:meeting.php");
//                    }
//                }
//            }

// An attempt to rename attachments


//            for ($i = 0; $i < $total; $i++) {
//                // Get the temp file path, RETURNS "D:\xampp\tmp\php5540.tmp"
//                $tmp_file_path = $_FILES['subject_attachment']['tmp_name'][$i];
//                // Make sure there's a file path
//                if ($tmp_file_path != "") {
//                    // Allow certain file formats
//                    $allowed_formats = array("pdf", "png", "gif", "jpeg", "jpg");
//                    // Set up our new file path
//                    $new_file_path = "../img/";
//                    $file_name = basename($_FILES["subject_attachment"]["name"][$i]);
//                    $file_type = pathinfo($new_file_path, PATHINFO_EXTENSION);
//                    $new_file_name = "m" . $meeting_id . "s" . $row["max(subject_id)"] . $i . ".$file_type";
//                    if (in_array($file_type, $allowed_formats)) {
//                        // Upload file to server
//                        if (move_uploaded_file($_FILES["subject_attachment"]["tmp_name"][$i], $new_file_path . $new_file_name))
//                        {
//                            $attachment_stmt = $conn->prepare("INSERT INTO `subject_attachment`
//                                                        (`attachment_name`, `attachment_title` `subject_id`)
//                                                    VALUES
//                                                        (?, ?, ?)");
//                            $attachment_stmt->bind_param("ssi", $new_file_name, $file_name, $row["max(subject_id)"]);
//                            $attachment_stmt->execute();
//                        }
//                    }
//                    else
//                    {
//                        $_SESSION["error"]["file_type"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload";
//                        header("location:update_product.php");
//                    }
//                }
//            }