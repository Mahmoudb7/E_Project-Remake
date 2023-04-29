<?php
require_once "db.php";
require_once "functions.php";

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>

<!DOCTYPE HTML>
<html>
    <body>
        <?php
        admin_header("Add Formation Users");
        if (is_logged_in()):
            if (is_admin())
            {
                ?>
                <div id="su" class="sign" style="margin: auto">
                    <form method="post" action="add_formation_user_code.php" enctype="multipart/form-data">
                        <div>
                            <h1>Add Formation Users</h1>
                        </div><br>
                        <table style="width: 80%; text-align: center">
                            <tr>
                                <th>User</th>
                                <th>Add</th>
                            </tr>
                            <?php
                            $users_stmt = $conn->prepare("SELECT user_id, first_name, last_name, job_title 
                                                                        FROM users");
                            $users_stmt->execute();
                            $users_result = $users_stmt->get_result();
                            while ($users_row = $users_result->fetch_assoc())
                            {
                                ?>
                                <tr>
                                    <td><?=$users_row["first_name"] . " " . $users_row["last_name"]?></td>
                                    <td>
                                        <input type="checkbox" name="users[]" value="<?=$users_row['user_id'] . ','
                                                                                        . $users_row['job_title']?>">
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table><br>
                        <button type="submit" name="add_formation_user_btn" class="button">Add</button>
                        <input type="reset" value="Reset" class="button"><br><br>
                    </form>
                </div>
                <br>
            <?php
            }
        endif;
        footer();
        ?>
    </body>
</html>
