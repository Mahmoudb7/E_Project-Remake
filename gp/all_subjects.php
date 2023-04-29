<?php
require_once ("db.php");
require_once ("functions.php");

// start session if not started
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <?php admin_header("Subjects");
        if(isset($_POST["subject_btn"])){
            // Check if user is logged in
            if (is_logged_in())
            {
                ?>
                <h1 style="text-align: center;">All Subjects</h1>
                <?php
                if(@$_SESSION["admin"] and $_POST["is_confirmed"] == 0)
                {
                    ?>
                    <form method="post" action="add_subject.php">
                        <input type="hidden" value="<?=@$_POST['meeting_id']?>" name="meeting_id">
                        <button class="button" name="add_subject_btn">Add Subject</button>
                    </form>
                    <?php
                }
                ?>
                <table style="width: 90%; margin:auto">
                    <tr>
                        <th>Order</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Type</th>
                        <th>Attachment</th>
                        <th>Picture</th>
                        <th>Decision</th>
                        <?php
                        if (@$_SESSION["admin"] && $_POST["is_confirmed"] == 0):
                            ?>
                            <th>Update</th>
                            <th>Delete</th>
                        <?php
                        endif;
                        ?>
                    </tr>
                    <?php
                    $subject_type_stmt = $conn->prepare("SELECT * FROM subject_type");
                    $subject_type_stmt->execute();
                    $subject_type_result = $subject_type_stmt->get_result();
                    $subject_type = array();
                    while ($s_t_row = $subject_type_result->fetch_assoc())
                    {
                        $subject_type[$s_t_row["subject_type_id"]] = $s_t_row["subject_type_name"];
                    }
                    $stmt = $conn->prepare("SELECT * FROM subject WHERE meeting_id = ? ORDER BY -order_id desc");
                    $stmt->bind_param("i",$_POST["meeting_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc())
                    {
                        ?>
                        <tr>
                            <td><?=$row["order_id"]?></td>
                            <td><?=$row["subject_name"]?></td>
                            <td><?=$row["subject_details"]?></td>
                            <td><?=$subject_type[$row["subject_type_id"]]?></td>
                            <?php
                            $attachment_stmt = $conn->prepare("SELECT attachment_name FROM subject_attachment 
                                                                        WHERE subject_id = ?");
                            $attachment_stmt->bind_param("i", $row["subject_id"]);
                            $attachment_stmt->execute();
                            $result1 = $attachment_stmt->get_result();
                            // Old attachment uploading code
//                            $attachments = array();
//                            while ($row1 = $result1->fetch_assoc())
//                            {
//                                $attachments[] = $row1["attachment_name"];
//                            }
//                            ?>
<!--                            <td style="text-align: center">-->
<!--                                --><?php
//                                foreach ($attachments as $a)
//                                {
//                                    ?>
<!--                                    <a href="../img/--><?php //=$a?><!--" target="_blank" class="hyperlink">--><?php //=$a?><!--</a><br>-->
<!--                                    --><?php
//                                }
//                                ?>
<!--                            </td>-->

<!--                            New attachment uploading code without attachments array-->
                            <td style="text-align: center">
                                <?php
                                while ($row1 = $result1->fetch_assoc())
                                {
                                    ?>
                                    <a href="../img/<?=$row1['attachment_name']?>" target="_blank" class="hyperlink">
                                        <?=$row1['attachment_name']?>
                                    </a><br>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($result1->num_rows >= 1 and $_POST["is_confirmed"] == 0):
                                ?>
                                    <br>
                                    <form method="post" action="subject_attachment.php">
                                        <button class="button" type="submit" name="att_btn">Edit</button>
                                        <input type="hidden" name="subject_id" value="<?=$row['subject_id']?>">
                                        <input type="hidden" name="is_confirmed" value="<?=$_POST['is_confirmed']?>">
                                    </form>
                                    <?php
                                endif
                                ?>
                            </td>
                            <?php
                            $picture_stmt = $conn->prepare("SELECT picture_name FROM p39_subject_picture
                            WHERE subject_id = ?");
                            $picture_stmt->bind_param("i", $row["subject_id"]);
                            $picture_stmt->execute();
                            $result2 = $picture_stmt->get_result();
                            $pictures = array();
                            while ($row2 = $result2->fetch_assoc())
                            {
                            $pictures[] = $row2["picture_name"];
                            }
                            ?>
                            <td style="text-align: center">
                                <?php
                                foreach ($pictures as $a)
                                {
                                    ?>
                                    <img src="../img/<?=$a?>" alt="picture" style="width: 100px; height: 100px"/><br>
                                    <?php
                                }
                                ?>
                            </td>

                            <td>
                                <?php
                                $subject_decision = $conn->prepare("SELECT * FROM decision where subject_id = ?");
                                $subject_decision->bind_param("s", $row["subject_id"]);
                                $subject_decision->execute();
                                $subject_decision_result = $subject_decision->get_result();
                                if (!$subject_decision_result->num_rows == 0)
                                {
                                    echo"Taken";
                                }
                                elseif(@$_SESSION["admin"] || @$_SESSION["dean"])
                                {
                                    ?>
                                    <form style="text-align: center;" action="add_decision.php" method="post">
                                        <button class="button" style="margin: auto; width: auto; height: auto" name="decision_btn">Add</button>
                                        <input type="hidden" value="<?=$row['subject_id']?>" name="subject_id">
                                    </form>
                                    <?php
                                }
                                else
                                {
                                    echo"Not Taken";
                                }
                                ?>
                            </td>
                            <?php
                            if (@$_SESSION["admin"] and $_POST["is_confirmed"] == 0)
                            {
                                ?>

                                <td>
                                    <form style="text-align: center;" action="update_subject.php" method="post">
                                        <button class="button" style="margin: auto; width: auto; height: auto" name="update_btn">Edit</button>
                                        <input type="hidden" value="<?= $row["subject_id"]?>" name="update_id">
                                        <input type="hidden" value="<?=@$_POST['meeting_id']?>" name="meeting_id">
                                    </form>
                                </td>
                                <td style="text-align: center">
                                    <form action="delete_subject.php" method="post">
                                        <button class="button" style="width: auto; height: auto; margin: auto" name="delete_btn">
                                            Delete
                                        </button>
                                        <input type="hidden" value="<?=$row['subject_id']?>" name="delete_id">
                                    </form>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                    <?php
                    }
                    ?>
                </table><br>
                <?php
                footer();
            }
        }
        else
        {
            echo "You Need to use POST to view this page";
            if (@$_SESSION["loggedin"])
            {
                header("refresh:5; url=meeting.php");
            }
            else
            {
                header("refresh:5; url=login.php");
            }
        }
        ?>
    </body>
</html>
