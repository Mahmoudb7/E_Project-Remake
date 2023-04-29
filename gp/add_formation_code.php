<?php
require_once "db.php";
require_once "functions.php";

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

// Insert Formation Details into Database
$formation_insert = $conn->prepare("INSERT INTO p39_formation 
                                        (added_by, start_year) 
                                    VALUES 
                                        (?, ?)");
$formation_insert->bind_param("ii", $_SESSION["user_id"], $_POST["formation_year"]);

// Insert Formation Dates into Database
// Check if Formation Query was successfully executed
if ($formation_insert->execute())
{
    $dates_insert = $conn->prepare("INSERT INTO p39_dates 
                                        (month, year, formation_id) 
                                    VALUES 
                                        (?, ?, ?)");
    // Get Formation Year & Formation ID To insert into Dates Table
    $formation_year = $conn->prepare("SELECT * FROM p39_formation WHERE
                                        formation_id = (SELECT max(formation_id) FROM p39_formation)");
    $formation_year->execute();
    $formation_year_result = $formation_year->get_result();
    $formation_row = $formation_year_result->fetch_assoc();
    for ($i = 9; $i <= 12; $i++)
    {
        $dates_insert->bind_param("iii", $i, $formation_row["start_year"], $formation_row["formation_id"]);
        $dates_insert->execute();
    }
    $formation_end_year = $formation_row["start_year"] + 1;
    for ($i = 1; $i <= 8; $i++)
    {
        $dates_insert->bind_param("iii", $i, $formation_end_year, $formation_row["formation_id"]);
        $dates_insert->execute();
    }
    header("location: add_formation_user.php");
}
