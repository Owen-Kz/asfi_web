<?php
include_once ('header.php');

// Add reCAPTCHA keys - REPLACE THESE WITH YOUR ACTUAL KEYS
// Add reCAPTCHA keys - REPLACE THESE WITH YOUR ACTUAL KEYS
define('RECAPTCHA_SITE_KEY', '6LcEcsUrAAAAACd3CAtZIO54BjvF7viwD__b0vTB');
define('RECAPTCHA_SECRET_KEY', '6LcEcsUrAAAAAP4RLg3FraLr0ZQU0WYmoBLg_g8D');

$result = ""; 
if(isset($_POST['login_submit'])){
    $user = $_POST['user']; 
    $pwrd = $_POST['pwrd'];
    
    // reCAPTCHA verification
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    
    if(empty($user) || empty($pwrd)){
        $_SESSION['alert'] = "Email and Password is empty";
        $_SESSION['alert_code'] = "warning";
        $_SESSION['alert_link'] = "";
    } elseif(empty($recaptcha_response)) {
        $_SESSION['alert'] = "Please complete the reCAPTCHA verification";
        $_SESSION['alert_code'] = "error";
        $_SESSION['alert_link'] = "";
    } else {
        // Verify reCAPTCHA
        $recaptcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET_KEY."&response={$recaptcha_response}");
        $recaptcha_data = json_decode($recaptcha_verify);
        
        if (!$recaptcha_data->success) {
            // reCAPTCHA verification failed
            $_SESSION['alert'] = "reCAPTCHA verification failed. Please try again.";
            $_SESSION['alert_code'] = "error";
            $_SESSION['alert_link'] = "";
        } else {
            // reCAPTCHA successful, proceed with login
            $user = strip_tags($user);
            $user = $db->real_escape_string($user);
            
            $pwrd = strip_tags($pwrd);
            $pwrd = $db->real_escape_string($pwrd);
            $pwrd = md5($pwrd);
            
            $query = $db->query("SELECT * FROM members_registration WHERE member_email='$user' AND member_password='$pwrd' ");
            if($query->num_rows === 1){
                while($row =$query->fetch_object()){
                    $_SESSION['member_id'] = $row->member_id;
                }
                echo "<script> window.location.href='index.php';</script>";
                exit();
            } else {
                $_SESSION['alert'] = "Email and Password is incorrect. Please click on forgotten password to login";
                $_SESSION['alert_code'] = "error";
                $_SESSION['alert_link'] = "";
            }
        }
    }
}
?>

<title>Login  || African Science Frontiers Initiatives (ASFI)</title>

<!-- Add reCAPTCHA script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Page Title -->
<section class="page-title" style="background-image:url(images/image6.jpg)">
    <div class="auto-container">
        <div class="content-box">
            <h1>Membership Login  </h1>
            <ul class="bread-crumb">
                <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                <li>Membership Login </li>
            </ul>
        </div>
    </div>
</section>

<!--Login Register Section-->
<section class="login-register-area">
    <div class="auto-container">
        <div class="row">
            <div class="col-xl-3"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="form">
                    <div class="shop-page-title">
                        <div class="title">Login </div>
                        <p>Please this login is for members only. <a href="registration.php"> Click Here to Register as a member</a></p>
                    </div>
                    <div class="row">
                        <form action="" method="post">
                           
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="text" name="user" placeholder="Enter Your Email" value="<?php echo isset($_POST['user']) ? htmlspecialchars($_POST['user']) : ''; ?>" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="password" name="pwrd" placeholder="Enter Password" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            
                            <!-- reCAPTCHA Widget -->
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                                </div>
                            </div>
                            
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-sm-12">
                                        <button class="theme-btn btn-style-one" name="login_submit" type="submit">
                                            <span>Login</span>
                                        </button>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-sm-12">
                                        <p><a href="forgotten_password.php">Forgotten Password</a></p>
                                    </div>
                                </div>   
                            </div> 
                            
                        </form>    
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>

<?php include_once('footer.php');?>