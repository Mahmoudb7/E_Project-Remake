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
        admin_header("Add Subject");

        if (isset($_POST["add_subject_btn"])):
            if(is_admin()):
                ?>
                <div id="su" class="sign" style="margin: auto">
                    <form method="post" action="add_subject_code.php" enctype="multipart/form-data">
                        <div>
                            <h1>Add New Subject</h1>
                        </div><br>
                        <input type="hidden" value="<?=$_POST['meeting_id']?>" name="meeting_id">
                        <div>
                            <label for="subject_name">Name</label>
                            <input type="text" id="subject_name" name="subject_name" size="40px" class="textbox"
                                   placeholder="Enter Subject Name" required>
                        </div>
                        <div>
                            <label for="subject_details">Details</label>
                            <input type="text" id="subject_details" name="subject_details" size="40px" class="textbox"
                                   placeholder="Enter Subject Details" required>
                        </div>
                        <div>
                            <label for="subject_type">Type</label>
                            <select name="subject_type" id="subject_type" required>
                                <option value="" disabled selected>اختر</option>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM subject_type");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc())
                                {
                                    echo "<option value='{$row["subject_type_id"]}'>{$row['subject_type_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="subject_comment">Comments</label>
                            <input type="text" id="subject_comment" name="subject_comment" size="40px" class="textbox"
                                   placeholder="Enter Subject Comments">
                        </div>
                        <div>
                            <label for="subject_attachment">Attachment</label>
                            <input type="file" id="subject_attachment" name="subject_attachment[]" style="margin-right: 30px"
                                   accept="application/pdf, image/png, image/gif, image/jpeg" multiple>
                        </div>
                        <div>
                            <label for="subject_picture">Picture</label>
                            <input type="file" id="subject_picture" name="subject_picture[]" style="margin-right: 30px"
                                   accept="image/png, image/gif, image/jpeg" multiple>
                        </div>
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
                        <button name="add_subject_btn" class="button">Add</button>
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
