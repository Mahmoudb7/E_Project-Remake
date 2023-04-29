<?php
require_once ("db.php");
require_once ("functions.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["update_subject_btn"]))
{
    if(is_admin())
    {
        $select_old_row_stmt = $conn->prepare("SELECT * FROM subject WHERE subject_id = ?");
        $select_old_row_stmt->bind_param("i", $_POST["subject_id"]);
        if ($select_old_row_stmt->execute())
        {
            $select_old_row_result = $select_old_row_stmt->get_result();
            $old_row = "";
            $select_old_row = $select_old_row_result->fetch_assoc();
            foreach ($select_old_row as $key => $value)
            {
                $value = empty($value) ? "Null" : $value;
                $old_row .= empty($old_row) ? $value : ", " . $value;
            }
            $old_row = "(" . $old_row . ")";

            // Updating Subject details
            $order_id = (@$_POST["subject_order"] == "NULL" ? null : @$_POST["subject_order"]);
            $subject_name = clean_data($_POST["subject_name"]);
            $subject_details = clean_data($_POST["subject_details"]);
            $subject_type =  $_POST["subject_type"];
            $comments = (empty($_POST["subject_comment"]) ? null : clean_data($_POST["subject_comment"]));
            $update_stmt = $conn->prepare("UPDATE
                                              `subject`
                                            SET
                                              `order_id` = ?,
                                              `subject_name` = ?,
                                              `subject_details` = ?,
                                              `subject_type_id` = ?,
                                              `comments` = ?
                                            WHERE
                                                subject_id = ?");
            $update_stmt->bind_param("issisi", $order_id, $subject_name, $subject_details, $subject_type,
                $comments, $_POST["subject_id"]);
            if ($update_stmt->execute())
            {
                // Adding subject attachment
                // Allow certain file formats
                $attachment_allowed_types = array("pdf", "png", "gif", "jpeg", "jpg");
                $uploaded_attachments = Upload("subject_attachment", "../img/", $attachment_allowed_types);
                // Upload Subject Attachments to database
                if (!empty($uploaded_attachments))
                {
                    foreach ($uploaded_attachments as $key => $value)
                    {
                        $attachment_stmt = $conn->prepare("INSERT INTO `subject_attachment`
                                                        (`attachment_name`, `attachment_title`, `subject_id`, `added_by`)
                                                    VALUES
                                                        (?, ?, ?, ?)");
                        $attachment_stmt->bind_param("ssii", $value, $key, $_POST["subject_id"],
                            $_SESSION["user_id"]);
                        $attachment_stmt->execute();
                    }
                }

                // Allow certain file formats
                $pic_allowed_formats = array("png", "gif", "jpeg", "jpg");
                $uploaded_pictures = Upload("subject_picture", "../img/", $pic_allowed_formats);
                // Upload Subject Pictures to database
                if (!empty($uploaded_pictures))
                {
                    foreach ($uploaded_pictures as $key => $value)
                    {
                        $picture_stmt = $conn->prepare("INSERT INTO `p39_subject_picture`
                                                        (`picture_name`, `picture_title`, `subject_id`, `added_by`)
                                                    VALUES
                                                        (?, ?, ?, ?)");
                        $picture_stmt->bind_param("ssii", $value, $key, $_POST["subject_id"],
                            $_SESSION["user_id"]);
                        $picture_stmt->execute();
                    }
                }
//                $select_new_row_stmt = $conn->prepare("SELECT * FROM subject WHERE subject_id = ?");
//                $select_new_row_stmt->bind_param("i", $_POST["subject_id"]);
//                $select_new_row_result = $select_new_row_stmt->get_result();
                $select_old_row_stmt->execute();
                $select_new_row_result = $select_old_row_stmt->get_result();
                $new_row = NULL;
                $select_new_row = $select_new_row_result->fetch_assoc();
                foreach ($select_new_row as $key => $value)
                {
                    $value = empty($value) ? "Null" : $value;
                    $new_row .= empty($new_row) ? $value : ", " . $value;
                }
                $new_row = "(" . $new_row . ")";
                $insert_transaction = $conn->prepare("INSERT INTO `p39_subject_transaction`
                                                            (`subject_id`, `old_row`, `new_row`, `made_by`)
                                                        VALUES
                                                            (?, ?, ?, ?)");
                $insert_transaction->bind_param("issi", $_POST["subject_id"], $old_row, $new_row, $_SESSION["user_id"]);
                $insert_transaction->execute();
            }
        }

//        echo "<pre>";
//        print_r($uploaded_attachments);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($uploaded_pictures);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($old_row);
//        echo"</pre>";
//        echo "<pre>";
//        print_r($new_row);
//        echo"</pre>";
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
