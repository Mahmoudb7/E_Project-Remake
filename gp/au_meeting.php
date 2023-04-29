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
                    <?php
                    if (isset($_POST["update_btn"]))
                    {
                        echo "<form method='post' action='update_meeting_code.php' enctype='multipart/form-data'>";
                    }
                    else
                    {
                        echo "<form method='post' action='add_meeting_code.php' enctype='multipart/form-data'>";
                    }
                    ?>
                        <?php
                        if (isset($_POST["update_btn"]))
                        {
                            $meeting_id = @$_POST["update_id"];
                            $stmnt = $conn->prepare("SELECT * FROM meeting WHERE meeting_id = ?");
                            $stmnt->bind_param("i", $meeting_id);
                            $stmnt->execute();
                            $result = $stmnt->get_result();
                            $row = $result->fetch_assoc();
                            echo "<div><h1>Update Meeting</h1></div><br>";
                        }
                        else
                        {
                            echo "<div><h1>Add New Meeting</h1></div><br>";
                        }
                        ?>
                        <div>
                            <label for="meeting_name">Name</label>
                            <input type="text" id="meeting_name" name="meeting_name" size="40px" class="textbox"
                                   placeholder="Enter Meeting Name" required
                                   value="<?isset($_POST['update_btn']) ?? $row['meeting_name']?>">
                        </div>
                        <?php
                        if (isset($_POST["update_btn"]))
                        {
                            ?>
                            <div>
                                <label for='meeting_date'>Date</label>
                                <input type='date' id='meeting_date' name='meeting_date' size='40px' class='textbox'
                                       value="<?isset($_POST['update_btn']) ?? $row['meeting_date']?>">
                            </div>
                            <?php
                        }
                        ?>
                        <div>
                            <label for="meeting_current">Current</label>
                            <select name="meeting_current" id="meeting_current" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <option value=1>منعقد</option>
                                <option value=0>تم انعقاده مسبقًا</option>
                            </select>
                        </div>
                        <div>
                            <label for="meeting_confirmed">Confirmed</label>
                            <select name="meeting_confirmed" id="meeting_confirmed" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <option value=0>لم يتم التأكيد عليه</option>
                                <option value=1>تم التأكيد عليه</option>
                            </select>
                        </div>
                        <?php
                        if (isset($_POST["update_btn"]))
                        {
                            echo "<div>
                                    <label for='meeting_attachment'>Attachment</label>
                                    <input type='file' id='meeting_attachment' name='meeting_attachment[]' multiple
                                        style='margin-right: 30px' accept='application/pdf, image/png, image/gif, image/jpeg'>
                                  </div>";
                        }
                        ?>
                        <p class="error_msg"><?php
                            if(isset($_SESSION["error"]["file_type"]))
                            {
                                echo $_SESSION["error"]["file_type"];
                                unset($_SESSION["error"]["file_type"]);
                            }
                            if (isset($_SESSION["error"]["meeting"]))
                            {
                                echo $_SESSION["error"]["meeting"];
                                unset($_SESSION["error"]["meeting"]);
                            }
                            ?>
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
