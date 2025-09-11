<?php 
include_once('header.php');

include ('./includes/load_env.php');
$siteKey = $_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY');
$captchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'] ?? getenv('RECAPTCHA_SECRET_KEY');

// Add reCAPTCHA keys - REPLACE THESE WITH YOUR ACTUAL KEYS
define('RECAPTCHA_SITE_KEY', "$siteKey");
define('RECAPTCHA_SECRET_KEY', "$captchaSecret");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['submit_member_reg'])){
    
    // reCAPTCHA verification
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    
    if(empty($recaptcha_response)) {
        $_SESSION['alert'] = "Please complete the reCAPTCHA verification";
        $_SESSION['alert_code'] = "error";
        $_SESSION['alert_link'] = "registration.php";
    } else {
        // Verify reCAPTCHA
        $recaptcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET_KEY."&response={$recaptcha_response}");
        $recaptcha_data = json_decode($recaptcha_verify);
        
        if (!$recaptcha_data->success) {
            // reCAPTCHA verification failed
            $_SESSION['alert'] = "reCAPTCHA verification failed. Please try again.";
            $_SESSION['alert_code'] = "error";
            $_SESSION['alert_link'] = "registration.php";
        } else {
            // reCAPTCHA successful, proceed with registration
            $firstname = $_POST['first_name'];
            $firstname = strip_tags($firstname);
            $firstname = $db->real_escape_string($firstname);
            
            $surname = $_POST['sur_name'];
            $surname = strip_tags($surname);
            $surname = $db->real_escape_string($surname);
            
            $email = $_POST['email'];
            $email = strip_tags($email);
            $email = $db->real_escape_string($email);

            if(!empty($email)){
                $query_select_check = $db->query("SELECT member_id FROM members_registration WHERE member_email='$email'");
                if($query_select_check->num_rows > 0){
                    $_SESSION['alert'] = "Email Already Registered. Please Try Loging In. Thank You";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = "login.php";
                    exit;
                }
            }
            
            $gender = $_POST['gender'];
            $gender = strip_tags($gender);
            $gender = $db->real_escape_string($gender);
            
            $age = $_POST['age'];
            $age = strip_tags($age);
            $age = $db->real_escape_string($age);

            $affiliation = $_POST['affiliation'];
            $affiliation = strip_tags($affiliation);
            $affiliation = $db->real_escape_string($affiliation);

            $country_origin = $_POST['country_origin'];
            $country_origin = strip_tags($country_origin);
            $country_origin = $db->real_escape_string($country_origin);

            $current_position = $_POST['position'];
            $current_position = strip_tags($current_position);
            $current_position = $db->real_escape_string($current_position);

            $highest_degree = $_POST['Highest_degree'];
            $highest_degree = strip_tags($highest_degree);
            $highest_degree = $db->real_escape_string($highest_degree);

            $password = $_POST['password'];
    
            $confirmPassword = $_POST['confirm_password'];
            
            if($password===$confirmPassword){
                
                $password = strip_tags($password);
                $password = $db->real_escape_string($password);
                $password = md5($password);
                
            }else{
                $_SESSION['alert'] = "Password Mis-match. Pease check and try again. Thank You";
                $_SESSION['alert_code'] = "error";
                $_SESSION['alert_link'] = "registration.php";
                exit();
            }

            if ($country_origin === 'Nigeria') {
                if ( $highest_degree === 'Bachelor' OR $highest_degree === 'Masters'  OR $highest_degree === 'MD') {
                    $paymentLink = 'https://paystack.com/pay/asfimem1ng';
                } else {
                    $paymentLink = 'https://paystack.com/pay/asfimem2ng';
                }
            } else {
                if ( $highest_degree === 'Bachelor' OR $highest_degree === 'Masters'  OR $highest_degree === 'MD'){
                    $paymentLink = 'https://paystack.com/pay/asfiMem1';
                } else {
                    $paymentLink = 'https://paystack.com/pay/asfimem2';
                }
            }

            $message = "
                <html>
        
           
                <h4>ASFI Membership Confirmation Email</h4>

                <p>&nbsp;</p>
                
                <p>Dear $firstname,</p>
                
                <p>&nbsp;</p>
                
                <p>Thank you for registering to be a member of the African Science Frontiers Initiatives (ASFI). ASFI is a non-for-profit organization with vision to raise the next generation of African scientists who have the right competencies to drive Africa&rsquo;s developmental and transformational agenda through innovative scientific research. ASFI aims to instill excellence in Africa&rsquo;s science through competence acquisition, capacity building and career development.</p>
                
                <p>&nbsp;</p>
                
                <p>ASFI organizes hands-on courses, seminars, workshops, and mentoring in order to achieve its mission. As a member of ASFI, priority will be given to you in all of ASFI&rsquo;s activities, with judicious discounts in the activities and trainings that require fees to attend. Please note that to enjoy the benefits of your membership, you need to fulfil your membership financial obligation by paying your annual membership fee.</p>
                
                <p>&nbsp;</p>
                
                <p>We highly appreciate your decision to be a member of this organization and we believe that together we will work towards making Africa great again.</p>
                
                <p>&nbsp;</p>
                
                <p>To complete your membership registration, please follow the link below to pay your membership fee.</p>
                
                <p>&nbsp;</p>
                
                <p><a href='$paymentLink' target='_blank'>Click Here To make Payment </a></p>
                
                <p>&nbsp;</p>
                
                <p>Please note:</p>
                
                <p>For those paying from outside Nigeria, it is possible in some situations that your bank card payment is not authorized by your bank. Therefore, if for any reasons you have challenges paying with your card, please use the following information to make a bank transfer.</p>
                
                <p>&nbsp;</p>
                
                <p>BANK: ZENITH BANK PLC</p>
                
                <p>&nbsp;</p>
                
                <p>SORT CODE: 18-50-08</p>
                
                <p>&nbsp;</p>
                
                <p>SWIFT CODE: ZEIBNGLA</p>
                
                <p>&nbsp;</p>
                
                <p>ACCOUNT NAME: ASFI NETWORK</p>
                
                <p>&nbsp;</p>
                
                <p>ACCOUNT NUMBER 5072840626</p>
                
                <p>&nbsp;</p>
                
                <p>Please write to&nbsp;<a href='mailto:membership@africansciencefrontiers.com' target='_blank'>membership@africansciencefrontiers.com</a>&nbsp;if you have any questions.</p>
                
                <p>&nbsp;</p>
                
                <p>Welcome to the ASFI Family</p>
                
                <p>&nbsp;</p>
                
                <p>Best wishes,</p>
                
                <p>ASFI Membership Committee</p>
                
                <p>&nbsp;</p>
                
                <p>ASFI website:&nbsp;<a href='https://africansciencefrontiers.com/' target='_blank'>https://africansciencefrontiers.com/</a></p>
                
                <p>&nbsp;</p>
                
                <p>ASFI YouTube Channel:&nbsp;<a href='https://www.youtube.com/c/ASFIHubForResearchCapacityBuilding' target='_blank'>https://www.youtube.com/c/ASFIHubForResearchCapacityBuilding</a></p>
                
                <p>&nbsp;</p>
                
                <p>ASFI Twitter:&nbsp;@AfricanScience2</p>
                
                <p>&nbsp;</p>
                
                <p>ASFI LinkedIn:&nbsp;<a href='https://www.linkedin.com/in/african-science-frontiers-initiatives-asfi-74967b240/' target='_blank'>https://www.linkedin.com/in/african-science-frontiers-initiatives-asfi-74967b240/</a></p>
                </html>
            ";
            
            if(empty($firstname) || empty($email)){
                $_SESSION['alert'] = "Fill all field and Please Try Again";
                $_SESSION['alert_code'] = "error";
                $_SESSION['alert_link'] = "";
            }else{
                $query = $db->query("INSERT INTO members_registration (member_firstname, member_surname, member_email, member_gender, member_age, member_country, member_password, member_affiliate, member_highest_degree, member_position, member_reg_date, member_activation, member_payment) 
                                                 VALUES('$firstname', '$surname', '$email', '$gender', '$age', '$country_origin', '$password', '$affiliation', '$highest_degree', '$current_position', CURRENT_TIMESTAMP, ' ', 'Not paid')");
                // move image
                if($query){

                    //Load Composer's autoloader
                    require 'vendor/autoload.php';
                    //Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'africansciencefrontiers.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'mailme@africansciencefrontiers.com';                     //SMTP username
                        $mail->Password   = 'mailme@ASFI';                                    //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                   //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    
                        //Recipients
                        
                        $mail->setFrom('membership@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                        $mail ->AddAddress($email);
                        
                        //Name is optional
                        $mail->addReplyTo('info@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                    
                    
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Membership Registration Successful';
                        $mail->Body    = $message;

                        $mail->send();
                            $_SESSION['alert'] = "Hello $firstname, Your Membership Registration was successfully. An Email has been sent to you.";
                            $_SESSION['alert_code'] = "success";
                            $_SESSION['alert_link'] = $paymentLink;	
                    } catch (Exception $e) {
                            $_SESSION['alert'] = "Hello $firstname, Your Membership Registration was successfully. An Email has been sent to you.";
                            $_SESSION['alert_code'] = "success";
                            $_SESSION['alert_link'] = $paymentLink;
                    }

                   
                }else{
                    $_SESSION['alert'] = "Membership Registration Not successfully. Please Try Again";
                    $_SESSION['alert_code'] = "error";
                    $_SESSION['alert_link'] = "registration.php";
                }
            }
        }
    }
}

?>

<!--
ASFI membership payment links:

Discounted (20 USD)
https://paystack.com/pay/asfiMem1

Regular (40 USD)
https://paystack.com/pay/asfimem2


Discounted (Naira)
https://paystack.com/pay/asfimem1ng

Regular (Naira)
https://paystack.com/pay/asfimem2ng
-->
<title>Membership Registration  || African Science Frontiers Initiatives (ASFI)</title>

<!-- Add reCAPTCHA script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Page Title -->
<section class="page-title" style="background-image:url(images/image6.jpg)">
    <div class="auto-container">
        <div class="content-box">
            <h1>Membership Registration  </h1>
            <ul class="bread-crumb">
                <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                <li>Membership Registrations </li>
            </ul>
        </div>
    </div>
</section>

<!--Login Register Section-->
<section class="login-register-area">
    <div class="auto-container">
      
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="text-center">
                    <img src="images/virtual-images/regImage.jpeg" alt="" width="400px" title=""><br><br>
                </div>
                <h4>Registration is now open for the 2025 membership round. The overarching goals of ASFI membership are to:</h4>
                    <ul>
                        <li>Streamline activities to those who actively share in ASFI vision</li>
                        <li>Create a place of belonging for all members</li>
                        <li>Ensure that members own the ASFI movement</li>
                        <li>Ensure robust commitment from members</li>
                    </ul>
                    
                    <h5>Membership into ASFI will attracts an annual membership fee (January-December each year). Members who fulfil their annual fee obligation and commit to the ASFI vision and mission are eligible for the following benefits:</h5>
                    <ul>
                        <li>Exclusively tailored trainings for maximum benefit</li>
                        <li>Exclusively tailored trainings for maximum benefit</li>
                        <li>Discounts in the following ASFI programs
                            <ul>
                                <li>Full scholarship or up to 50% discount in all ASFI courses</li>
                                <li>50% discount in ASFI annual conferences and boot camp</li>
                                <li>50% discount to publish in ASFI Research Journal (ASFIRJ)</li>
                            </ul>
                        </li>
                        <li>Only ASFI members will also participate in: 
                            <ul>
                                <li>ASFI annual Research Excellence Award</li>
                                <li>ASFI research activities</li>
                            </ul>
                        </li>
                <hr></ul>

                <div class="form">
                    <div class="shop-page-title">
                        <div class="title">Membership Registrations</div>
                    </div>
                    <div class="row">
                        <form action="" method="post">
                           
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="text" name="first_name" placeholder="First Name" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>

                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="text" name="sur_name" placeholder="Surname" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>

                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="email" name="email" placeholder="Enter Your Email" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                   <select name="gender" id="" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                   </select>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                   <select name="age" id="" required>
                                        <option value="">Age, years: </option>
                                        <option value="Below 30">Below 30</option>
                                        <option value="30-39 ">Between 30-39 </option>
                                        <option value="40-49 ">Between 40-49 </option>
                                        <option value="40-49 ">Between 50-59 </option>
                                        <option value="above 60 ">Above 60 </option>
                                   </select>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="password" name="password" placeholder="Create Password" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>

                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="text" name="affiliation" placeholder="Affiliation" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-building" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <input type="text" name="position" placeholder="Current position" required>
                                    <div class="icon-holder">
                                        <i class="fa fa-map" aria-hidden="true"></i>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <label for="">Country of Origin</label>
                                    <select name="country_origin" id="myCountry" onchange="myCountryFunction()" required>
                                        <option value=""></option>
                                        <!-- Country options remain the same -->
                                    </select>
                                </div>    
                            </div>
                          
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <label for="">Highest degree completed </label>
                                   <select name="Highest_degree" id="myDegree" onclick="myFunction()" required>
                                        <option value=""></option>
                                        <option value="Bachelor">Bachelor</option>
                                        <option value="Masters">Masters </option>
                                        <option value="MD">MD</option>
                                        <option value="PhD">PhD</option>
                                        <option value="Others">Others</option>
                                   </select>
                                   

                                    <script>
                                        function myCountryFunction() {
                                            var w = document.getElementById("myCountry");
                                            var y = w.selectedIndex;
                                            localStorage.setItem("lastname", w.options[y].text);
                                            result = ' ';
                                            document.getElementById("demo").innerHTML = result;
                                        }

                                        function myFunction() {
                                            var country  = localStorage.getItem("lastname");
                                            var x = document.getElementById("myDegree");
                                            var i = x.selectedIndex;
                                            var degree = x.options[i].text;

        
                                            if ('Nigeria' == country) {
                                                if ('Bachelor' == degree || 'Masters' == degree || 'MD' == degree) {
                                                    result = 'Discounted membership for those with ' + degree + ' is <b>₦10,000.00</b>  per year';
                                                } else {
                                                    result = 'Regular membership for those with ' + degree + ' is <b>₦20,000.00</b>  per year';
                                                }
                                            } else {
                                                if ('Bachelor' == degree || 'Masters' == degree || 'MD' == degree) {
                                                    result = 'Discounted membership for those with ' + degree + ' is <b>$20 dollars</b>  per year';
                                                } else {
                                                    result = 'Regular membership for those with ' + degree + ' is <b>$40 dollars</b>  per year';
                                                }
                                            }
                                            document.getElementById("demo").innerHTML = result;
                                        }
                                    </script>
                                    <p id="demo"></p>
                                </div>   
                            </div>

                            <hr>
                            <h5>ACKNOWLEDGEMENT AND COMMITMENT STATEMENTS:</h5>
                            <div class="col-xl-12">
                                <div class="remember-text">
                                    <div class="checkbox">
                                        <label>
                                            <input name="acknowledgement1" type="checkbox" required>
                                            <span>By ticking this box, I state that all information I have given on the form is, to the best of my knowledge, true and complete.</span>
                                        </label>
                                    </div>  
                                </div>
                            </div> 
                            <div class="col-xl-12">
                                <div class="remember-text">
                                    <div class="checkbox">
                                        <label>
                                            <input name="acknowledgement2" type="checkbox" required>
                                            <span>By ticking this box, I confirm that I embrace and committed to the vision and mission of ASFI. As required by ASFI, I will avail myself and skills when called upon to support ASFI in achieving its programs.</span>
                                        </label>
                                    </div>  
                                </div>
                            </div> 
                            
                            <!-- reCAPTCHA Widget -->
                            <div class="col-xl-12">
                                <div class="input-field">
                                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                                </div>
                            </div>
                            
                           <br>
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-sm-12">
                                        <button class="theme-btn btn-style-one" type="submit" name="submit_member_reg">
                                            <span>Submit</span>
                                        </button>
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