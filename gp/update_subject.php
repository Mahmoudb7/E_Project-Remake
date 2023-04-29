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
        admin_header("Update Subject");
        if (isset($_POST["update_btn"])):
            if(is_admin()):
                $subject_id = @$_POST["update_id"];
                $stmnt = $conn->prepare("SELECT * FROM subject WHERE subject_id = ?");
                $stmnt->bind_param("i", $subject_id);
                $stmnt->execute();
                $result = $stmnt->get_result();
                $row = $result->fetch_assoc();
                ?>
                <div id="su" class="sign" style="margin: auto">
                    <form method="post" action="update_subject_code.php" enctype="multipart/form-data">
                        <div>
                            <h1>Update Subject</h1>
                        </div><br>
                        <input type="hidden" name="subject_id" value="<?=$subject_id?>">
                        <div>
                            <label for="subject_order">Order</label>
                            <select name="subject_order" id="subject_order">
                                <option value='' disabled selected>اختر</option>
                                <?php
                                $order_stmt = $conn->prepare("SELECT order_id FROM subject WHERE order_id > 0 
                                                                    and meeting_id = ?");
                                $order_stmt->bind_param("i", $_POST["meeting_id"]);
                                $order_stmt->execute();
                                $order_result = $order_stmt->get_result();
                                $order_array = array();
                                while($order_row = $order_result->fetch_assoc())
                                {
                                    $order_array[] = $order_row["order_id"];
                                }
                                $stmt1 = $conn->prepare("SELECT * FROM subject WHERE meeting_id = ?");
                                $stmt1->bind_param("i", $_POST["meeting_id"]);
                                $stmt1->execute();
                                $result1 = $stmt1->get_result();
                                $rows_num = $result1->num_rows;
                                for($i = 1; $i <= $rows_num; $i++)
                                {
                                    if(!in_array($i, $order_array))
                                    {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    elseif($row["order_id"] == $i)
                                    {
                                        echo"<option value='$i' selected>$i</option>";
                                    }
                                }
                                ?>
                                <option value="NULL">N/A</option>
                            </select>
                        </div>
                        <div>
                            <label for="subject_name">Name</label>
                            <input type="text" id="subject_name" name="subject_name" size="40px" class="textbox"
                                   placeholder="Enter Subject Name" value="<?=$row['subject_name']?>" required>
                        </div>
                        <div>
                            <label for="subject_details">Details</label>
                            <input type="text" id="subject_details" name="subject_details" size="40px" class="textbox"
                                   placeholder="Enter Subject Details" value="<?=$row['subject_details']?>" required>
                        </div>
                        <div>
                            <label for="subject_type">Type</label>
                            <select name="subject_type" id="subject_type" required>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM subject_type");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row1 = $result->fetch_assoc())
                                {
                                    if ($row1["subject_type_id"] == $row["subject_type_id"])
                                    {
                                        echo "<option value='{$row1["subject_type_id"]}' selected>
                                                {$row1['subject_type_name']}</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='{$row1["subject_type_id"]}'>
                                                {$row1['subject_type_name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="subject_comment">Comments</label>
                            <input type="text" id="subject_comment" name="subject_comment" size="40px" class="textbox"
                                   placeholder="Enter Subject Comments" value="<?=$row['comments']??''?>">
                        </div>
                        <div>
                            <label for="subject_attachment">Attachment</label>
                            <input type="file" id="subject_attachment" name="subject_attachment[]" style="margin-right: 30px"
                                   accept="application/pdf, image/png, image/gif, image/jpeg" multiple>
                        </div>
<!--                        --><?php
//                        $att_stmt = $conn->prepare("SELECT * FROM subject_attachment WHERE subject_id = ?");
//                        $att_stmt->bind_param("i",$subject_id);
//                        $att_stmt->execute();
//                        $att_result = $att_stmt->get_result();
//                        while($att_row = $att_result->fetch_assoc())
//                        {
//                            ?>
<!--                            <form method="post" action="">-->
<!--                                <input type="hidden" value="--><?php //=$att_stmt['attachment_id']?><!--">-->
<!--                                <a href="../img/--><?php //=$att_row['attachment_name']?><!--">-->
<!--                                    --><?php //=$att_row['attachment_name']?>
<!--                                </a>-->
<!--                                <button class="button">Delete</button>-->
<!--                                <br>-->
<!--                            </form>-->
<!--                            --><?php
//                        }
//                        ?>
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
                        <button name="update_subject_btn" class="button">Update</button>
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