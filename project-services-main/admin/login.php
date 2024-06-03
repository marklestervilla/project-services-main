<?php
session_start();
include('includes/header.php');

if (isset($_SESSION['auth'])) {
    $_SESSION['status'] = "You are already logged in";
    header('Location: index.php');
    exit(0);
}
?>

<body style="background-color: hsl(0, 0%, 96%);">
    <section style="height: 100vh; display: flex; justify-content: center; align-items: center;">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <?php
                    if (isset($_SESSION['auth_status'])) {
                        $status = $_SESSION['auth_status'];
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i></strong> ' . $status . '
                  </div>';
                        unset($_SESSION['auth_status']);
                    }
                    ?>
                    <h1 class="my-2 display-3 fw-bold ls-tight" style="font-size: 85px; font-weight: 800; margin-right: 20px; line-height: 0.8;">
                        <span style="color: #333; font-family: fantasy, cursive, sans-serif;">
                            The best partner
                        </span><br />
                        <span class="text-primary" style="font-size: 45px; margin-right: 50px; font-weight: bold; font-family: fantasy, cursive, sans-serif;">
                            <span style="font-weight: bold;">
                                for your construction services
                            </span>
                        </span>
                    </h1>

                    <p style="color: hsl(217, 10%, 50.8%); margin-right:25px ">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                        quibusdam tempora at cupiditate quis eum maiores libero
                        veritatis? Dicta facilis sint aliquid ipsum atque?
                    </p>
                </div>
                <div class="col-lg-5">
                    <?php
                    alertMessage();
                    ?>
                    <div class="card">
                        <div class="card-body login-card-body" style="padding: 10px 22px;">
                            <p class="login-logo">
                                <img src="./images/icon-gbua.jpg" width="50px" height="50px" alt="">
                            </p>
                            <p class="login-box-msg" style="text-align: center;">Welcome to GBUA</p>
                            <form action="logincode.php" method="POST">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email" id="email" title="Please enter your email" value="<?php echo isset($_SESSION['login_email']) ? $_SESSION['login_email'] : ''; ?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" title="Please enter your password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" name="login_btn" class="btn btn-primary btn-block">Sign
                                            In</button>
                                    </div>
                                </div>
                            </form>
                            <div class="social-auth-links text-center mb-3">
                                <p>-- OR --</p>
                                <a href="../project-customer/customer-index.php" class="btn btn-block btn-primary">
                                    <i class="fas fa-user mr-2"></i> Continue as Customer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<?php include('includes/script.php'); ?>
<?php include('includes/footer.php'); ?>