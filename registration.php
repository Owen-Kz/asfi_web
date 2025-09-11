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
                              
                                                    <option value="">Country of Origin</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Åland Islands">Åland Islands</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antarctica">Antarctica</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia (Plurinational State of)">Bolivia (Plurinational State of)</option>
                                                    <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cabo Verde">Cabo Verde</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo (the Democratic Republic of the)">Congo (the Democratic Republic of the)</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Curaçao">Curaçao</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czechia">Czechia</option>
                                                    <option value="Ivoiry coast">Côte d'Ivoire</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Eswatini">Eswatini</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands [Malvinas]">Falkland Islands [Malvinas]</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guernsey">Guernsey</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                                    <option value="Holy See">Holy See</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran (Islamic Republic of)">Iran (Islamic Republic of)</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Isle of Man">Isle of Man</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jersey">Jersey</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Korea (the Democratic People Republic of)">Korea (the Democratic People's Republic of)</option>
                                                    <option value="Korea (the Republic of)">Korea (the Republic of)</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Lao People Democratic Republic">Lao People's Democratic Republic</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macao">Macao</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia (Federated States of)">Micronesia (Federated States of)</option>
                                                    <option value="Moldova (the Republic of)">Moldova (the Republic of)</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Palestine">Palestine</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn">Pitcairn</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Republic of North Macedonia">Republic of North Macedonia</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russian Federation">Russian Federation</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Réunion">Réunion</option>
                                                    <option value="Saint Barthélemy">Saint Barthélemy</option>
                                                    <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                    <option value="Saint Lucia<">Saint Lucia</option>
                                                    <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia">Serbia</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                                    <option value="South Sudan">South Sudan</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                    <option value="Taiwan (Province of China)">Taiwan (Province of China)</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Timor-Leste">Timor-Leste</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom of Great Britain and Northern Ireland">United Kingdom of Great Britain and Northern Ireland</option>
                                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                    <option value="United States of America">United States of America</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Viet Nam">Viet Nam</option>
                                                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                    <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
                                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                    <option value="Western Sahara">Western Sahara</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
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