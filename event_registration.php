<?php include_once('header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$non_members = '50';
$members = '20';
$nigerian_non_member = '50000';
$nigerian_members = '20000';
$with_code = '0';


if(isset($_GET['event'])){
	$event_id = $_GET['event'];
}

if(isset($_POST['submit_course_reg'])){
    $permittedChars ='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $Submitcode = substr(str_shuffle($permittedChars), 0, 4);

    $firstname = $_POST['firstname'];
    $firstname = strip_tags($firstname);
    $firstname = $db->real_escape_string($firstname);

    $lastname = $_POST['lastname'];
    $lastname = strip_tags($lastname);
    $lastname = $db->real_escape_string($lastname);
    
    $email = $_POST['email'];
    $email = strip_tags($email);
    $email = $db->real_escape_string($email);
    
    $gender = $_POST['gender'];
    $gender = strip_tags($gender);
    $gender = $db->real_escape_string($gender);
    
    $age = $_POST['age'];
    $age = strip_tags($age);
    $age = $db->real_escape_string($age);

    $country_origin = $_POST['country_origin'];
    $country_origin = strip_tags($country_origin);
    $country_origin = $db->real_escape_string($country_origin);

    $country_residence = $_POST['country_residence'];
    $country_residence = strip_tags($country_residence);
    $country_residence = $db->real_escape_string($country_residence);

    $highest_degree = $_POST['highest_degree'];
    $highest_degree = strip_tags($highest_degree);
    $highest_degree = $db->real_escape_string($highest_degree);

    $title = $_POST['title'];
    $title = strip_tags($title);
    $title = $db->real_escape_string($title);

    $wphone_number = $_POST['wphone_number'];
    $wphone_number = strip_tags($wphone_number);
    $wphone_number = $db->real_escape_string($wphone_number);

    $affliliation = $_POST['affliliation'];
    $affliliation = strip_tags($affliliation);
    $affliliation = $db->real_escape_string($affliliation);

    $membership = $_POST['membership'];
    $membership = strip_tags($membership);
    $membership = $db->real_escape_string($membership);

    $member_Id = $_POST['member_Id'];
    $member_Id = strip_tags($member_Id);
    $member_Id = $db->real_escape_string($member_Id);


    if($membership === 'YES' AND empty($member_Id)){
        echo"<script>
            alert('Please Enter Your Membership Number, If you are a member or select NO. Thank you');
            window.location.href=''
        </script> ";
            exit();
    }

    if(!empty($member_Id)){
        $queryCode = $db->query("SELECT * FROM membership_code WHERE member_code='$member_Id' ");
        if($queryCode->num_rows === 1){
            $member_Id = $member_Id;
            $membership = 'YES';

        }else{
            echo"<script>
            alert('You Entered A wrong Membership ID, please check and try again. Thank you');
            window.location.href=''
            </script>
            ";
            exit();
        }

    }


    $discount_code = $_POST['discount_code'];

    $Discount_avaliable = '';


    if(!empty($discount_code)){
       
        if($discount_code === 'ASFI-2025-MVACBC'){

               $Discount_avaliable = 'yes';
            
        }else{
            echo"<script>
                alert('Your Discount Code is wrong, please check and try again. Thank you');
                window.location.href=''
            </script>
            ";
            exit();
        }
    }
    if(!empty($Discount_avaliable)){
        $paymentContent = array(
            'paymentPrice' => $with_code,
            'Text' => 'Registration With Discount Code is FREE',
        );
        $text = "Registration With Discount Code is FREE";
    }else{
        if($country_origin === 'Nigeria'){
            if($membership === 'YES'){
                 $paymentContent = array(
                    'paymentPrice' => $nigerian_members,
                    'Text' => 'Nigerian ASFI Member to Pay ₦',
                    'currency' => 'NGN',

                );
                $text = "Nigerian ASFI Member to Pay ₦".number_format($nigerian_members, 2);
            }else{
                    $paymentContent = array(
                        'paymentPrice' => $nigerian_non_member,
                        'Text' => 'Nigerian ASFI Non-Member to Pay ₦',
                        'currency' => 'NGN',
                    );
                    $text = "Nigerian ASFI Non-Member to Pay ₦".number_format($nigerian_non_member, 2);
                
            }
        }else{
            if($membership === 'YES'){
                $paymentContent = array(
                    'paymentPrice' => $members,
                    'Text' => 'ASFI Member to Pay $',
                    'currency' => 'USD',
                );
                $text = "ASFI Member to Pay $".number_format($members, 2);

            }else{
                    $paymentContent = array(
                        'paymentPrice' => $non_members,
                        'Text' => 'ASFI Non-Member to Pay $',
                        'currency' => 'USD',
                    );
                    $text = "ASFI Non-Member to Pay $".number_format($non_members, 2);
            }
        }
    }
    $paymentContent = json_encode($paymentContent,JSON_FORCE_OBJECT);



    $message = "
       <html>
        <p>Dear $firstname</p>

        <p>Thank you for registering to the 3rd ASFI Virtual Multidisciplinary Conference and Boot Camp. This email is to confirm your registration.  Please use the link below to pay your conference registration fee before the stipulated deadline. Please note that this link is unique to you and must not be shared to another person.</p>
                
        <p>Payment links:&nbsp;</p>
        
        <p>$text </p>
        <p><a href='https://africansciencefrontiers.com/payment_page_event.php?SubmitCode=$Submitcode'>Click Here To Make Payment</a></p>
                
        <p>Best wishes,</p>
        
        <p>ASFI Courses Admin<br />
        African Science Frontiers Initiatives<br />
        &quot;Raising the next generation of African scientists...&quot;<br />
        www.africansciencefrontiers.com<br />
        Twitter: @AfricanScience2</p>
    </html>
    ";
    
    if(empty($firstname) || empty($highest_degree)){
        $_SESSION['alert'] = "Fill all field and Please Try Again";
        $_SESSION['alert_code'] = "error";
        $_SESSION['alert_link'] = "";
    }else{
        $query = $db->query("INSERT INTO `events_registration` (`event_id`, `firstname`, `lastname`, `email`, `title`, `gender`, `age`, `highest_degree`, `country_origin`, `country_residence`, `wphone_number`, `affliliation`, `membership`, `member_Id`, `paymentContent`, `submitCode`, `payment_status`, `reg_date`)
        VALUES ('$event_id', '$firstname', '$lastname', '$email', '$title', '$gender', '$age', '$highest_degree', '$country_origin', '$country_residence', '$wphone_number', '$affliliation', '$membership', '$member_Id', '$paymentContent', '$Submitcode', '', CURRENT_TIMESTAMP)");


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
                $mail->Password   = 'mailme@ASFI';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587; 
                //Recipients
                
                $mail->setFrom('conference2023@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                $mail ->AddAddress($email);
                
                //Name is optional
                $mail->addReplyTo('conference2023@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
            
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Event Registration Successful';
                $mail->Body    = $message;

                $mail->send();
                    $_SESSION['alert'] = "Hello $firstname, Your Event Registration was successful.  $text . Please Click Ok to continue to the payment Link.";
                    $_SESSION['alert_code'] = "success";
                    $_SESSION['alert_link'] = 'payment_page_event.php?SubmitCode='.$Submitcode;	
            } catch (Exception $e) {
                    $_SESSION['alert'] = "Hello $firstname, Your Event Registration was successful. $text . Please Click Ok to continue to the payment Link.";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = 'payment_page_event.php?SubmitCode='.$Submitcode;
            }

           
        }else{
            $_SESSION['alert'] = "Event Registration Not successfully. Please Try Again";
            $_SESSION['alert_code'] = "error";
            $_SESSION['alert_link'] = "";
        }
    }   
    
}


?>
<title>3rd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp  || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>3rd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp 2025</h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>3rd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp  </li>
                </ul>
            </div>
        </div>
    </section>
    <style>
        label.error{
            color:red;
            display: block;
            font-size: 12px;
        }
    </style>

     <!-- Causes Details -->
     <div class="sidebar-page-container cause-details">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="donate-form-area" id="form">
                        <div class="donate-form-wrapper">
                            <div class="sec-title">
                                <div class="text-center">
                                  <!--  <img src="images/virtual-images/conf_reg.jpg" alt="" width="400px" title=""><br><br> -->
                                    <p>THEME</p>
                                    <h1>Beyond Boundaries: Breaking Collaborative Frontiers for Impactful Research and Career</h1>
                                </div>
                               
                            </div>
                            <hr>
                            <form  action="" method="post" name="formValidate" id="formValidate" class="donate-form default-form">
                                <div class="contact-form">
                                    <div class="row clearfix">
                                        <div class="col-lg-6 col-md-6 column">
                                            <div class="form-group">
                                                <label for="firstname"><b>FIRST NAME</b></label>
                                                <input type="text" id="firstname" name="firstname" required placeholder="Enter your First Name">
                                            </div>
                                        </div> 
                                        <div class="col-lg-6 col-md-6 column">
                                            <div class="form-group">
                                                <label for="lastname"><b>LAST NAME</b></label>
                                                <input type="text" id="lastname" name="lastname" required placeholder="Enter your Last Name">
                                            </div>
                                        </div> 
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="email"><b>EMAIL</b></label>
                                                <input type="email" id="email" name="email" required placeholder="Enter your contact Email">
                                            </div>
                                        </div> 
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                            <label for="presentation_type"><b>TITLE</b></label>
                                                <select class="form-controlt" name="title" required>
                                                    <option value="">Your Title</option>
                                                    <option value="Prof">Prof.</option>
                                                    <option value="Dr">Dr.</option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Mrs">Mrs.</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                            <label for="presentation_type"><b>GENDER</b></label>
                                                <select class="form-controlt" name="gender" required>
                                                    <option value="">Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                            <label for="age"><b>AGE</b></label>
                                                <select class="form-controlt" name="age" required>
                                                    <option value="">Age</option>
                                                    <option value="< 30 years">< 30 years</option>
                                                    <option value="30-39 years">30-39 years</option>
                                                    <option value="40-49 years">40-49 years</option>
                                                    <option value="50-59 years">50-59 years</option>
                                                    <option value="60 years and above">60 years and above </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                            <label for="highest_degree"><b>HIGHEST DEGREE EARNED</b></label>
                                                <select id="highest_degree" class="form-controlt" name="highest_degree" required>
                                                    <option value="">Select Your Highest Degree</option>
                                                    <option value="PhD">PhD</option>
                                                    <option value="Masters">Masters</option>
                                                    <option value="Bachelors">Bachelors</option>
                                                    <option value="MD">MD</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="country_origin"><b>COUNTRY OF ORIGIN</b></label>
                                                <select name="country_origin" class=" form-controlt" required>
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
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="country_residence"><b>COUNTRY OF RESIDENCE</b></label>
                                                <select name="country_residence" class=" form-controlt" required>
                                                    <option value="">Country of Residence</option>
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
                                                    <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                                                    <option value="Republic of the Congo">Republic of the Congo</option>
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
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="wphone_number"><b>WHATSAPP PHONE NUMBER</b></label>
                                                <input type="text" id="wphone_number" name="wphone_number" placeholder="Please Enter your WhatsApp Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="affliliation"><b>AFFILIATION(S)</b></label>
                                                <input type="text" id="affliliation" name="affliliation" required placeholder="Insert your affiliation(s)">
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="membership"><b>ASFI MEMBERSHIP</b></label>
                                                <select id="membership" class="form-controlt" required name="membership">
                                                    <option value="">=== Are You A Member Of ASFI? ===</option>
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="member_Id"><b>IF YES, WHAT IS MEMBERSHIP ID?</b></label>
                                                <input type="text" id="member_Id" name="member_Id" placeholder="IF YES, WHAT IS MEMBERSHIP ID?">
                                            </div>
                                        </div>



                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="discount_code"><b>DO YOU HAVE ANY REGISTRATION DISCOUNT CODE?</b></label>
                                                <input type="text" id="discount_code" name="discount_code" placeholder="ENTER DISCOUNT CODE">
                                            </div>
                                        </div>


                                        
                                    
                                      
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group d-flex align-items-center justify-content-between">
                                                <button class="theme-btn btn-style-one" name="submit_course_reg" type="submit"><span>Submit</span></button>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php include_once('footer.php');?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>

    $("#formValidate").validate({
    rules:{
        firstname:{
            minlength: 2,
            maxlength: 300
        },
        lastname:{
            minlength: 2,
            maxlength: 300
        },
        special_request:{
            minlength: 10,
            maxlength: 500
        },
       
        author:{
            minlength: 2,
            maxlength: 300
        },
        email:{
            email:true
        },
       
        affliliation:{
            minlength: 2,
            maxlength: 300
        }
    },

    messages: {
        firstname:{
            required: "Please Enter your First Name",
            minlength: "First Name Must Be More than 2 Characters",
            maxlength: "First Name Must not Be More than 300 Characters"
        },

        lastname:{
            required: "Please Enter your Last Name",
            minlength: "Last Name Must Be More than 2 Characters",
            maxlength: "Last Name Must not Be More than 300 Characters"
        },
       
       
        email:"Please Enter Valid Email",
        affliliation:{
            required: "Please Enter The Affliliation(s) of the Author(s) Of The Abstract ",
            minlength: "Affliliation(s)  Must Be More than 2 Characters",
            maxlength: "Affliliation(s)  Must not Be More than 300 Characters"
        }
      },

    submitHandler: function(form) {
        form.submit();
    }

   });
</script>