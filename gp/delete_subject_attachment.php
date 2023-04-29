<?php
require_once "db.php";

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["delete_btn"]))
{
    $stmnt = $conn->prepare("DELETE FROM subject_attachment WHERE attachment_id = ?");
    $stmnt->bind_param("i", $_POST["attachment_id"]);
    $stmnt->execute();
    header("location:meeting.php");
}