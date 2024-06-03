<?php
session_start();

if(!isset($_SESSION['auth']))
{
    $_SESSION['auth_status'] = "Login to Access Dashboard";
    header("Location: login.php");
    exit(0);
} 
else
{
   if($_SESSION['auth_role'] != "1" && $_SESSION['auth_role'] != "2")
   {
    $_SESSION['auth_status'] = "You Are Not Authorized as Admin";
    header("Location: customer-index.php");
    exit(0);
   }
}


?>