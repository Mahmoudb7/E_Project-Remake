<?php
require_once ("db.php");
require_once ("functions.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["add_subject_btn"])) {
    if (is_admin())
    {
        // Adding subject attachment
        $meeting_id = $_POST["meeting_id"];
        $stmt = $conn->prepare("SELECT max(subject_id) FROM subject WHERE meeting_id = ?");
        $stmt->bind_param("i", $meeting_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Attachments Upload Code
        $files = array_filter($_FILES["subject_attachment"]["name"]);
        $total = count($files);
        $attachment_allowed_types = array("pdf", "png", "gif", "jpeg", "jpg");
        echo"<pre>";
        print_r(Upload("subject_attachment", "../img/", $attachment_allowed_types));
        echo"</pre>";
    }
}