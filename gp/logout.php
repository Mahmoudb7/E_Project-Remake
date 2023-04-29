<?php
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}
unset($_SESSION);
session_destroy();
session_write_close();
header("location:login.php");
die;