<?php
require_once ("db.php");
require_once ("functions.php");

// start session if not started
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["add_attachment_btn"]))
{
    $attachment_allowed_types = array("pdf", "png", "gif", "jpeg", "jpg");
    $uploaded_attachments = Upload("subject_attachment1", "../img/", $attachment_allowed_types);
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
    header("location:meeting.php");
}