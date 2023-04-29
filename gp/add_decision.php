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
    admin_header("Add Decision");

    if (isset($_POST["decision_btn"])):
        if(is_admin()):
            ?>
            <div id="su" class="sign" style="margin: auto">
                <form method="post" action="add_decision_code.php" enctype="multipart/form-data">
                    <div>
                        <h1>Add New Decision</h1>
                    </div><br>
                    <input type="hidden" name="subject_id" value="<?=$_POST['subject_id']?>">
                    <div>
                        <label for="decision_type">نوع القرار</label>
                        <select name="decision_type" id="decision_type" required>
                            <option value="" disabled selected>اختر</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM decision_type");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc())
                            {
                                echo "<option value='{$row["decision_type_id"]}'>{$row['decision_type_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="decision_details">صيغة القرار</label>
                        <input type="text" id="decision_details" name="decision_details" size="40px" class="textbox"
                               placeholder="Enter Decision Details" required>
                    </div>
                    <div>
                        <label for="decision_needs_action">هل له جواب تنفيذي</label>
                        <input type="radio" name="decision_needs_action" id="decision_needs_action" value="1">Yes<br>
                        <input type="radio" name="decision_needs_action" id="decision_needs_action" value="0" CHECKED>No
                    </div>
                    <div>
                        <label for="decision_comment">ملاحظات</label>
                        <input type="text" id="decision_comment" name="decision_comment" size="40px" class="textbox"
                               placeholder="Enter Decision Comments">
                    </div>
                    <br>
                    <button name="add_decision_btn" class="button">Add</button>
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
