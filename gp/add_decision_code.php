<?php
require_once ("db.php");
require_once ("functions.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

if (isset($_POST["add_decision_btn"]))
{
    if(is_admin())
    {
        // Adding decision details
        $subject_id = $_POST["subject_id"];
        $decision_type = $_POST["decision_type"];
        $decision_details = clean_data($_POST["decision_details"]);
        $decision_needs_action = $_POST["decision_needs_action"];
        $comments = clean_data($_POST["decision_comment"]);
        if(empty($_POST["decision_comment"]))
        {
            $comments = null;
        }
        $insert_stmt = $conn->prepare("INSERT INTO `decision`
                                            (`decision_details`, `decision_type_id`, `subject_id`, `needs_action`, 
                                             `is_action_done`, `comments`) 
                                          VALUES 
                                            (?, ?, ?, ?, ?, ?)");
        if ($_POST["decision_needs_action"] == 0)
        {
            $decision_is_action_done = 0;
            $insert_stmt->bind_param("ssiiis", $decision_details, $decision_type, $subject_id,
                $decision_needs_action, $decision_is_action_done, $comments);
        }
        else
        {
            $decision_is_action_done = NULL;
            $insert_stmt->bind_param("ssiiis", $decision_details, $decision_type, $subject_id,
                $decision_needs_action, $decision_is_action_done, $comments);
        }
        $insert_stmt->execute();
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