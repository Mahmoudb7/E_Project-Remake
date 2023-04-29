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
        <?php admin_header("Meetings");
        // Check if user is logged in
        // if (@$_SESSION["loggedin"] === true) (OLD WAY)
        if (is_logged_in())
        {
            ?>
            <h1 style="text-align: center">All Meetings</h1><br>
            <table style="width: 90%; margin:auto">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Current</th>
                    <th>Confirmed</th>
                    <th>Attachment</th>
                    <th>Show Subjects</th>
                    <?php
                    if (@$_SESSION["admin"]):
                        ?>
                        <th>Attendance</th>
                        <th>Update</th>
                        <th>Delete</th>
                    <?php
                    endif;
                    ?>
                </tr>
                <?php
                $stmt = $conn->prepare("SELECT * FROM meeting order by meeting_id");
                $stmt->execute();
                $result = $stmt->get_result();
                $n = 1;
                while($row = $result->fetch_assoc()):
                    if(@$_SESSION["admin"] || @$_SESSION["dean"] || $row["is_confirmed"] == 1):
                    ?>
                    <tr>
                        <td><?=$n?></td>
                        <td><?=$row["meeting_name"]?></td>
                        <td><?=$row["meeting_date"]?></td>
                        <td><?php
                            switch($row["is_current"])
                            {
                                case 1:
                                    echo "منعقد";
                                    break;
                                case 0:
                                    echo "تم انعقاده مسبقًا";
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php
                            switch($row["is_confirmed"])
                            {
                                case 1:
                                    echo "تم التأكيد عليه";
                                    break;
                                case 0:
                                    echo "لم يتم التأكيد عليه";
                                    break;
                            }
                            ?>
                        </td>
                        <?php
                        $attachment_stmt = $conn->prepare("SELECT attachment_name FROM meeting_attachment 
                                                                    WHERE meeting_id = ?");
                        $attachment_stmt->bind_param("i", $row["meeting_id"]);
                        $attachment_stmt->execute();
                        $result1 = $attachment_stmt->get_result();
                        $attachments = array();
                        while ($row1 = $result1->fetch_assoc())
                        {
                            $attachments[] = $row1["attachment_name"];
                        }
                        ?>
                        <td style="text-align: center">
                            <?php
                            foreach ($attachments as $a)
                            {
                                ?>
                                <a href="../img/<?=$a?>" target="_blank" class="hyperlink"><?=$a?></a><br>
                            <?php
                            }
                            ?>
                        </td>
                        <!-- Set this to show subjects -->
                        <td>
                            <form method="post" action="all_subjects.php" style="text-align: center;">
                                <input type="hidden" value="<?=$row['meeting_id']?>" name="meeting_id">
                                <input type="hidden" value="<?=$row['is_confirmed']?>" name="is_confirmed">
                                <button class="button" name="subject_btn">Subjects</button>
                            </form>
                        </td>
                        <?php
                        if (@$_SESSION["admin"] || @$_SESSION["dean"])
                        {
                            if ($row["is_confirmed"] === 0)
                            {
                                ?>
                                <td>
                                    <form method="post" action="attendance.php" style="text-align: center;">
                                        <input type="hidden" value="<?=$row['meeting_id']?>" name="meeting_id">
                                        <button class="button" name="attendance_btn">Attendance</button>
                                    </form>
                                </td>
                                <td>
                                    <form style="text-align: center;" action="update_meeting.php" method="post">
                                        <input type="hidden" value="<?=$row["meeting_id"]?>" name="update_id">
                                        <button class="button" style="margin: auto; width: auto; height: auto" name="update_btn">Edit</button>
                                    </form>
                                </td>
                                <td style="text-align: center">
                                    <form action="delete_meeting.php" method="post">
                                        <button class="button" style="width: auto; height: auto; margin: auto" name="delete_btn">
                                            Delete
                                        </button>
                                        <input type="hidden" value="<?=$row['meeting_id']?>" name="delete_id">
                                    </form>
                                </td>
                                <?php
                            }
                        }
                        endif;
                        $n += 1;
                        ?>
                    </tr>
                <?php
                endwhile;
                ?>
            </table><br>
            <?php
            footer();
        }
        ?>
    </body>
</html>
