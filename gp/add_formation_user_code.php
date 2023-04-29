<?php
require_once "db.php";
require_once "functions.php";

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
if(isset($_POST["users"]) && is_array($_POST["users"]))
{
    $formation_id_stmt = $conn->prepare("SELECT max(formation_id) FROM p39_formation");
    if ($formation_id_stmt->execute())
    {
        $formation_id_result = $formation_id_stmt->get_result();
        $formation_id_row = $formation_id_result->fetch_assoc();
        $insert_formation_user_stmt = $conn->prepare("INSERT INTO p39_formation_user VALUES (?, ?, ?)");
        foreach ($_POST["users"] as $user)
        {
            $user_job_array = explode(",", $user);
            $insert_formation_user_stmt->bind_param("iis", $formation_id_row["max(formation_id)"],
                $user_job_array[0], $user_job_array[1]);
            $insert_formation_user_stmt->execute();
        }
    }
}
header("location: meeting.php");