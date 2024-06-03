<?php
session_start();
include('config/dbcon.php');

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input to prevent SQL injection
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    $log_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $log_query_run = mysqli_query($con, $log_query);

    if (mysqli_num_rows($log_query_run) > 0) {
        foreach ($log_query_run as $row) {
            $user_id = $row['id'];
            $user_name = $row['name'];
            $user_email = $row['email'];
            $user_phone = $row['phone'];
            $role_as = $row['role_as'];
        }
            
        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = "$role_as"; //0=User, 1=Admin, 2=SuperAdmin
        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_phone' => $user_phone,
        ];

        if($_SESSION['auth_role'] == '1') //1=Admin
        {
            $_SESSION['status'] = "Welcome to Admin Dashboard!";
            header('Location: index.php');
            exit(0);
        }
        elseif($_SESSION['auth_role'] == '0') //0=User
        {
            $_SESSION['status'] = "You Are Logged In";
            header('Location: http://localhost/project-services-main-1/project-services-main/project-customer/customer-index.php');
            exit(0);
        }
        elseif($_SESSION['auth_role'] == '2') //2=SuperAdmin
        {
            $_SESSION['status'] = "Welcome to SuperAdmin Dashboard!";
            header('Location: http://localhost/project-services-main-1/project-services-main/admin/index.php');
            exit(0);
        }

    } 
    else 
    {
        $_SESSION['status'] = "Invalid Email & Password";
        $_SESSION['login_email'] = $email; // Store the entered email in session
        header('Location: login.php');
    }
} else {
    $_SESSION['status'] = "Access Denied";
    header('Location: login.php');
}
?>
