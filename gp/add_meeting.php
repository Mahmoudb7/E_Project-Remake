<?php
require_once ("db.php");
require_once ("functions.php");

// start session if not started
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
    <body>
        <?php
        admin_header("Add Meeting");
        if(is_logged_in()):
            if (is_admin()):
                ?>
                <div id="su" class="sign" style="margin: auto">
                    <form method="post" action="add_meeting_code.php" enctype="multipart/form-data">
                        <?php
                        $meeting_number_stmt = $conn->prepare("SELECT max(meeting_number) FROM meeting");
                        $meeting_number_stmt->execute();
                        $meeting_number_result = $meeting_number_stmt->get_result();
                        $meeting_number_row = $meeting_number_result->fetch_assoc();
                        ?>
                        <div>
                            <h1>Add New Meeting</h1>
                        </div><br>
                        <div>
                            <label for="meeting_number">Number</label>
                            <input type="number" id="meeting_number" name="meeting_number" size="40px" class="textbox"
                                   placeholder="Enter Meeting Number">
                            <label style="font-weight: normal; font-size: 15px">(Last Meeting Numer: <?=$meeting_number_row['max(meeting_number)']?>)</label><br>
                        </div>
                        <div>
                            <label for="meeting_month">Month</label>
                            <select name="meeting_month" id="meeting_month" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++)
                                {
                                    echo"<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="meeting_year">Year</label>
                            <select name="meeting_year" id="meeting_year" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <?php
                                $formation_stmt = $conn->prepare("SELECT formation_id, start_year FROM p39_formation");
                                $formation_stmt->execute();
                                $formation_result = $formation_stmt->get_result();
                                while ($formation_row = $formation_result->fetch_assoc())
                                {
                                    echo "<option value={$formation_row['start_year']}>{$formation_row['start_year']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="meeting_current">Current</label>
                            <select name="meeting_current" id="meeting_current" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <option value=1>منعقد</option>
                                <option value=0>تم انعقاده مسبقًا</option>
                            </select>
                        </div>
                        <div>
                            <label for="meeting_status">Status</label>
                            <select name="meeting_status" id="meeting_status" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <option value="pending">غير مؤكد</option>
                                <option value="confirmed">مؤكد</option>
                                <option value="finished">منتهي</option>
                            </select>
                        </div>
                        <div>
                            <label for="meeting_formation">Formation</label>
                            <select name="meeting_formation" id="meeting_formation" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <?php
                                $formation_stmt = $conn->prepare("SELECT formation_id, start_year FROM p39_formation");
                                $formation_stmt->execute();
                                $formation_result = $formation_stmt->get_result();
                                while ($formation_row = $formation_result->fetch_assoc())
                                {
                                    $end_year = $formation_row["start_year"] + 1;
                                    echo "<option value={$formation_row['formation_id']}>{$formation_row['start_year']}-$end_year</option>";
                                }
                                ?>
                            </select>
                        </div>
            <!--            <div>-->
            <!--                <label for="meeting_attachment">Attachment</label>-->
            <!--                <input type="file" id="meeting_attachment" name="meeting_attachment[]" style="margin-right: 30px"-->
            <!--                       accept="application/pdf, image/png, image/gif, image/jpeg" multiple>-->
            <!--            </div>-->
                        <p class="error_msg"><?php
    //                        if(isset($_SESSION["error"]["file_type"]))
    //                        {
    //                            echo $_SESSION["error"]["file_type"];
    //                            unset($_SESSION["error"]["file_type"]);
    //                        }
                            if (isset($_SESSION["error"]["meeting"]))
                            {
                                echo $_SESSION["error"]["meeting"];
                                unset($_SESSION["error"]["meeting"]);
                            }
    //                        ?>
                        </p>
                        <br>
                        <button name="add_meeting_btn" class="button">Add</button>
                        <br><br>
                    </form><br>
                </div>
            <?php
            endif;
        endif;
        footer();
        ?>
    </body>
</html>
