<?php

function admin_header($title)
{
    ?>
    <head>
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <meta name="keywords" content="HTML, CSS, PHP">
        <meta name="Description" content="E-Commerce Website">
        <title><?=$title?></title>
        <link rel="stylesheet" href="../css/Home.css">
        <link rel="stylesheet" href="../css/sign_up.css">
    </head>
    <header>
        <div class="top">
            <div id="logo">
                <a href=""><img src="../img/Facultylogo-removebg-preview.png" style="width: 100px; height: 100px"></a>
            </div>
            <label>Meetings</label>
                <?php
                if(@$_SESSION["loggedin"]):
                    ?>
                    <nav id="log" style="margin-left: auto; width: auto">
                        <ul>
                            <li>
                                <a class="hyperlink" href="meeting.php" style="margin-right: 15px">All Meetings</a>
                            </li>
                            <?php
                            if(@$_SESSION["admin"] === true || @$_SESSION["dean"] === true):
                                ?>
                                <li>
                                    <a class="hyperlink" href="add_meeting.php" style="margin-right: 15px">Add Meeting</a>
                                </li>
                                <li>
                                    <a class="hyperlink" href="add_user.php" style="margin-right: 15px">Add User</a>
                                </li>
                                <?php
                            endif;
                            ?>
                            <li class="welcome">
                                Welcome <?=@$_SESSION["name"]?>!
                                <?php
                                        if (@$_SESSION["admin"] === true || @$_SESSION["dean"] === true):
                                            ?>
                                            <a href="meeting.php" class="hyperlink">Admin Site</a>
                                        <?php
                                        endif;
                                        ?>
                            </li>
                            <button class="button" style="width: auto; height: auto" onclick="location.href='logout.php'">Logout</button>
                            <li><a href="" style="margin-left: 30px"><img src="../img/program-removebg-preview.png" alt="BIS"
                                                                          style="height: 80px; width: 80px"></a></li>
                        </ul>
                    </nav>
                <?php
                endif;
                ?>
        </div>
    </header><br>
<?php
}

function sign_header($title)
{
    ?>
    <head>
        <meta name="author" content="Mahmoud Badr">
        <meta name="viewport" content="width=device-width, initial scale=1.0">
        <meta name="keywords" content="HTML, CSS, PHP">
        <meta name="Description" content="E-Commerce Website">
        <title><?=$title?></title>
        <link rel="stylesheet" href="css/Home.css">
        <link rel="stylesheet" href="css/sign_up.css">
    </head>
    <header>
        <div class="top">
            <div id="logo">
                <a href="index.php"><img src="img/logoo.png"></a>
            </div>
            <label>Laptops</label>
            <nav class="logs">
                <ul>
                    <li><a href="sign_up.php" class="hyperlink" style="margin-right: 20px">Sign Up</a></li>
                    <li><a href="login.php" class="hyperlink">Login</a></li>
                    <li><a href="cart.php" style="margin-left: 30px"><img src="img/cart.png" alt="Cart"></a></li>
                </ul>
            </nav>
        </div><br><br>
    </header>
<?php
}

function products_header_wo_search($model)
{
    ?>
    <head>
        <meta name="author" content="Mahmoud Badr">
        <meta name="viewpoint" content="width=device-width, initial scale=1.0">
        <meta name="keywords" content="HTML, CSS, PHP">
        <meta name="Description" content="E-Commerce Website">
        <title><?=$model . " Laptops" ?></title>
        <link rel="stylesheet" href="css/Home.css">
    </head>
    <header>
        <div class="top">
            <div id="logo">
                <a href="index.php"><img src="img/logoo.png"></a>
            </div>
            <label>Laptops</label>
            <nav id="log" style="margin-left: auto">
                <ul>
                    <?php
                    if (@$_SESSION["loggedin"] !== true):
                        ?>
                        <li><a href="sign_up.php" class="hyperlink" style="margin-right: 20px">Sign Up</a></li>
                        <li><a href="login.php" class="hyperlink">Login</a></li>
                    <?php
                    else:
                        ?>
                        <li class="welcome">
                            Welcome <?php echo $_SESSION["name"]; ?>!
                            <?php
                                if (@$_SESSION["admin"] === true):
                                    ?>
                                    <a href="admin/all_products.php" class="hyperlink">Admin Site</a>
                                <?php
                                endif;
                                ?>
                        </li>
                        <button class="button" onclick="location.href='logout.php'">Logout</button>
                    <?php
                    endif; ?>
                    <li><a href="cart.php" style="margin-left: 30px; margin-right: 23px"><img src="img/cart.png" alt="Cart"></a></li>
                </ul>
            </nav>
        </div>
    </header><br>
    <div>
        <br>
        <a><img width=300px height=150px src="img/<?=$model?>-final.png" class="center"></a>
    </div> <br>
<?php
}

function footer()
{
    $year = date("Y");
    ?>
    <footer>
        <br><p>&copy;Laptops <?php echo $year?>. All Rights Reserved.</p>
        <div id="bottom_links"> <br>
            <ul>
                <li><a href="" class="hyperlink">Track Orders</a> </li>
                <li><a href="" class="hyperlink">Help Center</a> </li>
                <li><a href="" class="hyperlink">Contact Us</a> </li>
                <li><a href="" class="hyperlink">About Us</a> </li>
            </ul>
        </div><br>
        <div id="contact_us">
            <a href=""> <img src="http:\\localhost\E_Project [Remake]\img\fb48.png"></a>
            <a href=""> <img src="http:\\localhost\E_Project [Remake]\img\tw48.png"></a>
            <a href=""> <img src="http:\\localhost\E_Project [Remake]\img\ins48.png"></a>
        </div> <br>
    </footer>
<?php
}

function fetch_products($result)
{
    while($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td>
                <img style="width:310px; height:250px" src="<?php echo $row['Image']; ?>" class="laptop_img">
                <div class="laptop_name"> <?php echo $row['Name']; ?></div>
                <div class="laptop_desc"><?php echo $row['CPU']; ?></div>
                <div class="laptop_desc"><?php echo $row['GPU']; ?></div>
                <div class="laptop_desc"><?php echo $row['RAM'] . 'GB RAM'; ?></div><br>
                <span style="color: #c5181d; font-weight: bold;"><?php echo 'EGP' . $row['Price']; ?> </span><br><br>
                <form method="post" action="cart.php" class="cart-action">
                    <input type="number" class="product-quantity" name="quantity" value="1" min="1" max="100">
                    <input type="hidden" name="product_id" value="<?php echo $row["laptop_id"]?>">
                    <button type="submit" class="button" name="cart_btn">Add to Cart</button>
                </form><br>
            </td>
        </tr>
        <?php
    endwhile;
}

function clean_data($str)
{
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str, ENT_QUOTES, "UTF-8");
    return $str;
}

// Function for validating email
function is_valid_email($email)
{
    if (empty($email))
    {
        return false;
    }
    else
    {
        $email = clean_data($email);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }
    }
    return $email;
}

function is_admin():bool
{
    if(@$_SESSION["admin"])
    {
        return true;
    }
    else
    {
        ?>
        <p class="error_msg" style="text-align: center">
            You don't have authorization to view this page. You'll be redirected to the homepage in 5 seconds.
        </p><br>
        <?php
        header("refresh:5; url=meeting.php");
        footer();
        die();
    }
}

function is_logged_in():bool
{
    if(@$_SESSION["loggedin"] === true)
    {
        return true;
    }
    else
    {
        ?>
        <p class="error_msg" style="text-align: center">
            You need to log in to view this page. You'll be redirected to the login page in 5 seconds.
        </p><br>
        <?php
        header("refresh:5; url=login.php");
        footer();
        die();
    }
}

function Upload($source, $destination, $allowed_formats)
{
    $result = array();
//    $destination = self::Path($destination);

    if ((is_dir($destination) === true) && (array_key_exists($source, $_FILES) === true))
    {
        if (count($_FILES[$source], COUNT_RECURSIVE) == 5)
        {
            foreach ($_FILES[$source] as $key => $value)
            {
                $_FILES[$source][$key] = array($value);
            }
        }

        foreach (array_map('basename', $_FILES[$source]['name']) as $key => $value)
        {
            $new_file_path = $destination . $value;
            $file_type = pathinfo($new_file_path, PATHINFO_EXTENSION);
            if (in_array($file_type, $allowed_formats))
            {
                $result[$value] = false;
                if ($_FILES[$source]['error'][$key] == UPLOAD_ERR_OK)
                {
//                $file = ph()->Text->Slug($value, '_', '.');
                    $file = NULL;
                    $file = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file)));

                    if (file_exists($destination . $file) === true)
                    {
                        $file = substr_replace($file, '_' . md5_file($_FILES[$source]['tmp_name'][$key]) . ".$file_type", strrpos($value, '.'), 0);
//                        $file = substr_replace($file, '_' . hash_file('sha256', $_FILES[$source]['tmp_name'][$key]) . ".$file_type", strrpos($value,'.'),0);
                    }

                    if (move_uploaded_file($_FILES[$source]['tmp_name'][$key], $destination . $file) === true)
                    {
                        $result[$value] = $destination . $file;
                    }
                }
            }
        }
    }
    return $result;
}

//function Upload($source, $destination)
//{
//    $result = array();
////    $destination = self::Path($destination);
//
//    if ((is_dir($destination) === true) && (array_key_exists($source, $_FILES) === true))
//    {
//        if (count($_FILES[$source], COUNT_RECURSIVE) == 5)
//        {
//            foreach ($_FILES[$source] as $key => $value)
//            {
//                $_FILES[$source][$key] = array($value);
//            }
//        }
//
//        foreach (array_map('basename', $_FILES[$source]['name']) as $key => $value)
//        {
//            $result[$value] = false;
//            // Allow certain file formats
//            $allowed_formats = array("pdf", "png", "gif", "jpeg", "jpg");
//            $new_file_path = "../img/" . $_FILES[$source]["name"];
//            // $new_file_path = "../img/" . $value;
//            $file_type = pathinfo($new_file_path, PATHINFO_EXTENSION);
//            if (in_array($file_type, $allowed_formats))
//            {
//                if ($_FILES[$source]['error'][$key] == UPLOAD_ERR_OK) {
//                    //                $file = ph()->Text->Slug($value, '_', '.');
//                    $file = NULL;
//                    $file = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $file)));
//
//                    if (file_exists($destination . $file) === true) {
//                        $file = substr_replace($file, '_' . md5_file($_FILES[$source]['tmp_name'][$key]), strrpos($value, '.'), 0);
//                    }
//
//                    if (move_uploaded_file($_FILES[$source]['tmp_name'][$key], $destination . $file) === true) {
//                        $result[$value] = $destination . $file;
//                    }
//                }
//            }
//            else
//            {
//                $_SESSION["error"]["file_type"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload";
////                header("location:meeting.php");
//            }
//        }
//    }
//
//    return $result;
//}


//for ($i = 0; $i < $total; $i++) {
//    // Get the temp file path
//    $tmp_file_path = $_FILES['subject_attachment']['tmp_name'][$i];
//    // Make sure there's a file path
//    if ($tmp_file_path != "") {
//        // Allow certain file formats
//        $allowed_formats = array("pdf", "png", "gif", "jpeg", "jpg");
//        // Set up our new file path
//        $new_file_path = "../img/" . $_FILES["subject_attachment"]["name"][$i];
//        $file_name = basename($_FILES["subject_attachment"]["name"][$i]);
//        $file_type = pathinfo($new_file_path, PATHINFO_EXTENSION);
//        if (in_array($file_type, $allowed_formats)) {
//            // Upload file to server
//            if (move_uploaded_file($_FILES["subject_attachment"]["tmp_name"][$i], $new_file_path))
//            {
//                $attachment_stmt = $conn->prepare("INSERT INTO `subject_attachment`
//                                                        (`attachment_name`, `subject_id`)
//                                                    VALUES
//                                                        (?, ?)");
//                $attachment_stmt->bind_param("si", $file_name, $row["max(subject_id)"]);
//                $attachment_stmt->execute();
//            }
//        }
//        else
//        {
//            $_SESSION["error"]["file_type"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload";
//            header("location:update_product.php");
//        }
//    }
//}