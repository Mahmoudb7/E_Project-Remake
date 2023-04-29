<?php
require_once "db.php";
require_once "functions.php";

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["delete_btn"]))
{
    if(is_admin())
    {
        $stmnt = $conn->prepare("DELETE FROM subject WHERE subject_id = ?");
        $stmnt->bind_param("i", $_POST["delete_id"]);
        $stmnt->execute();
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