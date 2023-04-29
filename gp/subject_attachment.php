<?php
require_once ("db.php");
require_once ("functions.php");

// start session if not started
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>
<html>
    <body>
        <?php
        admin_header("Subject Attachments");
//        if (isset($_POST["att_btn"]))
//        {
            if(is_logged_in())
            {
                ?>
                <h1 style="text-align: center">Attachments</h1>
                <?php
                if(@$_SESSION["admin"] and $_POST["is_confirmed"] == 0)
                {
                        ?>
                        <form method="post" action="add_subject_attachment.php" enctype="multipart/form-data">
                            <input type="file" id="subject_attachment1" name="subject_attachment1[]" style="margin-right: 30px"
                                   accept="application/pdf, image/png, image/gif, image/jpeg" multiple>
                            <input type="hidden" value="<?=$_POST['subject_id']?>" name="subject_id">
                            <button class="button" name="add_attachment_btn">Add Attachment</button>
                        </form>
                        <?php
                }
                ?>
                <table>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <?php
                        if(@$_SESSION["admin"] and $_POST["is_confirmed"] == 0):
                        ?>
                        <th>Delete</th>
                        <?php
                        endif;
                        ?>
                    </tr>
                    <?php
                    $n = 1;
                    $attachment_stmt = $conn-> prepare("SELECT * FROM subject_attachment WHERE subject_id = ?");
                    $attachment_stmt-> bind_param("i", $_POST["subject_id"]);
                    $attachment_stmt->execute();
                    $attachment_result = $attachment_stmt-> get_result();
                    while ($attachment_row = $attachment_result-> fetch_assoc())
                    {
                        ?>
                        <tr>
                            <td><?=$n?></td>
                            <td><?=$attachment_row["attachment_title"]?></td>
                            <?php
                            if(@$_SESSION["admin"] and $_POST["is_confirmed"] == 0):
                            ?>
                            <td style="text-align: center">
                                <form action="subject_attachment.php" method="post">
                                    <button class="button" style="width: auto; height: auto; margin: auto" name="delete_btn">
                                        Delete
                                    </button>
                                    <input type="hidden" value="<?=$attachment_row['attachment_id']?>"
                                           name="attachment_id">
                                </form>
                            </td>
                            <?php
                            endif;
                            ?>
                        </tr>
                    <?php
                        $n++;
                    }
                    ?>
                </table>
                <?php
            }
//        }
        if(isset($_POST["delete_btn"]))
        {
            $delete_stmnt = $conn->prepare("DELETE FROM subject_attachment WHERE attachment_id = ?");
            $delete_stmnt->bind_param("i", $attachment_row["attachment_id"]);
            $delete_stmnt->execute();
        }

        footer();
        ?>
    </body>
</html>
