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
        admin_header("Add Formation");
        if (is_logged_in()):
            if (is_admin())
            {
                ?>
                <div id="su" class="sign" style="margin: auto">
                    <form method="post" action="add_formation_code.php" enctype="multipart/form-data">
                        <div>
                            <h1>Add New Formation</h1>
                        </div><br>
                        <div>
                            <label for="formation_year">Year</label>
                            <select name="formation_year" id="formation_year" required>
                                <option value="" disabled selected>اختر السنة</option>
                                <?php
                                $formation_years_stmt = $conn->prepare("SELECT start_year FROM p39_formation");
                                $formation_years_stmt->execute();
                                $formation_years_result = $formation_years_stmt->get_result();
                                $years = array();
                                while ($formation_years_row = $formation_years_result->fetch_assoc())
                                {
                                    $years[] = $formation_years_row["start_year"];
                                }
                                for ($i = date("Y") - 5; $i <= date("Y") + 5; $i++)
                                {
                                    if (!in_array($i, $years))
                                    {
                                        ?>
                                        <option value="<?=$i?>"><?=$i . "-" . ($i + 1)?></option>;
                                        <?php
                                    }
                                }
                                ?>
                            </select>
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
                        <button name="add_formation_btn" class="button">Add</button>
                        <br><br>
                    </form><br>
                </div>
        <?php
            }
        endif;
        footer();
        ?>
    </body>
</html>
