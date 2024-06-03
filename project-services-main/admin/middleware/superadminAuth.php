<?php

if($_SESSION['auth_role'] != "2")
{
    $_SESSION['auth_status'] = "You Are Not Authorized as Super Admin";
    header("Location: ../../../login.php");
    exit(0);
}


?>