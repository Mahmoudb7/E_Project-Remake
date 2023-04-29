<?php
require_once ("db.php");
require_once ("functions.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
    <body>
        <?php
        admin_header("Update Meeting");
        if(isset($_POST["update_btn"])):
            if(is_admin()):
                $meeting_id = @$_POST["update_id"];
                $stmnt = $conn->prepare("SELECT * FROM meeting WHERE meeting_id = ?");
                $stmnt->bind_param("i", $meeting_id);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $row = $result->fetch_assoc();
                ?>
                <div id="su" class="sign" style="margin: auto">
                    <form method="post" action="update_meeting_code.php" enctype="multipart/form-data">
                        <div>
                            <h1>Update Meeting</h1>
                        </div><br>
                        <input type="hidden" name="meeting_id" value="<?=$meeting_id?>">
                        <div>
                            <label for="meeting_name">Name</label>
                            <input type="text" id="meeting_name" name="meeting_name" size="40px" class="textbox"
                                   placeholder="Enter Meeting Name" value="<?=$row["meeting_name"]?>" required>
                        </div>
                        <div>
                            <label for="meeting_date">Date</label>
                            <input type="date" id="meeting_date" name="meeting_date" size="40px" class="textbox"
                                   value="<?=$row["meeting_date"]?>">
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
                            <label for="meeting_confirmed">Confirmed</label>
                            <select name="meeting_confirmed" id="meeting_confirmed" required class="textbox">
                                <option value="" disabled selected>اختر</option>
                                <option value=0>لم يتم التأكيد عليه</option>
                                <option value=1>تم التأكيد عليه</option>
                            </select>
                        </div>
                        <div>
                            <label for="meeting_attachment">Attachment</label>
                            <input type="file" id="meeting_attachment" name="meeting_attachment[]" style="margin-right: 30px"
                                   accept="application/pdf, image/png, image/gif, image/jpeg" multiple>
                        </div>
                        <p class="error_msg"><?php
                            if(isset($_SESSION["error"]["file_type"]))
                            {
                                echo $_SESSION["error"]["file_type"];
                                unset($_SESSION["error"]["file_type"]);
                            }

                            ?>
                        </p>
                        <br>
                        <button name="update_meeting_btn" class="button">Update</button>
                        <br><br>
                    </form><br>
                </div>
            <?php
            endif;
        else:
            echo"You Need to use POST to view this page";
            if(@$_SESSION["loggedin"])
            {
                header("refresh:5; url=meeting.php");
            }
            else
            {
                header("refresh:5; url=login.php");
            }
        endif;
        footer();
        ?>
    </body>
</html>