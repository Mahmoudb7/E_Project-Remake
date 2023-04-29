<?php
require_once ("db.php");
require_once ("functions.php");

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
    <body>
        <?php admin_header("Add User");
        if (is_admin()):
            ?>
            <div id="su" class="sign" style="margin:auto; height: auto">
                <form method="post" action="add_user_code.php">
                    <div>
                        <h1>Add a New User</h1><br>
                    </div>
                    <div>
                        <label for="first_name">First Name</label>
                        <input type="text" autocomplete="given-name" id="first_name" name="first_name" size="40 px"
                               class="textbox" placeholder="Enter user's First Name" required>
                    </div>
                    <div>
                        <label for="last_name">Last Name</label>
                        <input type="text" autocomplete="family-name" id="last_name" name="last_name" size="40px"
                               class="textbox" placeholder="Enter user's Last Name" required>
                    </div>
                    <div>
                        <label for="job_title">Job Title</label>
                        <input type="text" id="job_title" name="job_title" size="40px" class="textbox"
                               placeholder="Enter user's Job Title" required>
                    </div>
                    <div>
                        <label for="user_type">Role</label>
                        <select name="user_type" id="user_type" required>
                            <option value="" disabled selected>اختر</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM user_type");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc())
                            {
                                echo "<option value='{$row["user_type_id"]}'>{$row['user_type_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <article>
                        <label for="birthdate">Date of birth</label>
                        <input type="date" id="birthdate" name="birthdate" size="40px" class="textbox" required>
                    </article>
                    <article>
                        <label for="gender">Gender</label>
                        <input type="radio" id="gender" name="gender" value="M" checked>Male<br>
                        <input type="radio" id="gender" name="gender" value="F">Female
                    </article>
                    <div>
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" size="40px" class="textbox"
                               placeholder="Enter your Email" required>
                    </div>
                    <div>
                        <label for="new-password">Password</label>
                        <input type="password" name="password" size="40px" class="textbox" autocomplete="new-password"
                               id="new-password" placeholder="Enter your Password" required>
                    </div>
                    <div>
                        <label for="password1">Confirm Password</label>
                        <input type="password" name="password1" size="40px" class="textbox" autocomplete="new-password"
                               id="new-password" placeholder="Confirm your Password" required>
                    </div>
                    <div>
                        <label for="user_image">Image</label>
                        <input type="file" id="user_image" name="user_image" style="margin-right: 30px"
                               accept="image/png, image/gif, image/jpeg">
                    </div><br>
                    <button type="submit" id="add_user_btn" name="add_user_btn" class="button">Sign Up</button><br><br>
                </form>
            </div><br><br>
            <?php
        endif;
        footer();
        ?>
    </body>
</html>