<?php include_once('header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['course_id'])){

	$course_id = $_GET['course_id'];

	$result = $db->query("SELECT * FROM `courses` WHERE `course_id`= '$course_id'");
	    while($product = $result->fetch_assoc()): 
			 $course_title = $product['course_title'];
			 $course_duration = $product['course_duration'];
			 $course_target = $product['course_target'];
			 $course_image = $product['course_image'];
			 $course_details = $product['course_details'];
             $course_video_link = $product['course_video_link'];
			 $course_status = $product['course_status'];
             $course_price_variation = $product['course_price_variation'];

		endwhile; 
        if(!empty($course_price_variation)){

                $course_price_variation = json_decode($course_price_variation, true);

                $outside_africa = $course_price_variation['outside_africa'];
                $african_non_members = $course_price_variation['african_non_members'];
                $african_members = $course_price_variation['african_members'];
                $nigerian_non_member = $course_price_variation['nigerian_non_member'];
                $nigerian_members = $course_price_variation['nigerian_members'];
                $with_code = $course_price_variation['with_code'];
                $nigerian_with_code = $course_price_variation['nigerian_with_code'];
        }else{
            $outside_africa = '';
            $african_non_members = '';
            $african_members = '';
            $nigerian_non_member = '';
            $nigerian_members = '';
            $with_code = '';
            $nigerian_with_code = '';
        }

        if(isset($_POST['submit_course_reg'])){
            
            $permittedChars ='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $Submitcode = substr(str_shuffle($permittedChars), 0, 4);

            // Sanitize inputs
            function sanitizeInput($db, $input) {
                return $db->real_escape_string(strip_tags($input));
            }

            $firstname = sanitizeInput($db, $_POST['firstname']);
            $surname = sanitizeInput($db, $_POST['surname']);
            $email = sanitizeInput($db, $_POST['email']);
            $gender = sanitizeInput($db, $_POST['gender']);
            $age = sanitizeInput($db, $_POST['age']);
            $affiliation = sanitizeInput($db, $_POST['affiliation']);
            $country_origin = sanitizeInput($db, $_POST['country_origin']);
            $country_residence = sanitizeInput($db, $_POST['country_residence']);
            $current_position = sanitizeInput($db, $_POST['current_position']);
            $highest_degree = sanitizeInput($db, $_POST['highest_degree']);
            $degree_progress = sanitizeInput($db, $_POST['Degree_progress']);
            $research_interest = sanitizeInput($db, $_POST['research_interest']);
            $current_project = sanitizeInput($db, $_POST['current_project']);
            $prev_asfi_course = sanitizeInput($db, $_POST['prev_asfi_course']);
            $why_interested = sanitizeInput($db, $_POST['why_interested']);
            $membership = sanitizeInput($db, $_POST['membership']);
            $membership_number = sanitizeInput($db, $_POST['membership_number']);
            $discount_code_q = sanitizeInput($db, $_POST['discount_code_q']);
            $discount_code = sanitizeInput($db, $_POST['discount_code']);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['alert'] = "Invalid email address.";
            $_SESSION['alert_code'] = "error";
            header('Location: courses.php');
            exit();
        }


            if($membership === 'YES' AND empty($membership_number)){
                echo"<script>
                    alert('Please Enter Your Membership Number, If you are a member or select NO. Thank you');
                    window.location.href=''
                </script>
                    ";
                    exit();
            }
            
            if(!empty($membership_number)){
                $queryCode = $db->query("SELECT * FROM membership_code WHERE member_code='$membership_number' ");
                if($queryCode->num_rows === 1){
                    $membership_number = $membership_number;
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



            if($discount_code_q === 'YES' AND empty($discount_code)){
                echo"<script>
                    alert('Please Enter the Discount code your were given or select NO. Thank you');
                    window.location.href=''
                </script>
                    ";
                    
            }

            $Discount_avaliable = '';


            if($discount_code_q === 'YES' AND !empty($discount_code)){
               
                if($discount_code === 'ASFI2025SR&MA'){
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



            $Africa =  ['Algeria','Angola','Benin','Botswana','Burkina Faso','Burundi','Cabo Verde','Cameroon',
            'Central African Republic','Chad','Comoros','Democratic Republic of the Congo','Republic of the Congo','Ivoiry coast','Djibouti','Egypt','Equatorial Guinea','Eritrea','Ethiopia','Gabon','Gambia','Ghana','Guinea','Guinea Bissau','Kenya','Lesotho','Liberia','Libya','Madagascar','Malawi','Mali','Mauritania','Mauritius','Morocco','Mozambique','Namibia','Niger','Nigeria','Rwanda','Sao Tome and Principe','Senegal','Seychelles','Sierra Leone','Somalia','South Africa','South Sudan','Sudan','Swaziland','Tanzania','Togo','Tunisia','Uganda','Zambia','Zimbabwe'];
            $is_african = in_array($country_origin, $Africa);


            if($is_african){
                if($country_origin === 'Nigeria'){
                    if($membership === 'YES'){
                         if(!empty($Discount_avaliable)){
                            $paymentContent = array( 'paymentPrice' => $with_code,'Text' => 'Nigerian ASFI Member With Discount Code is free ', 'currency' => 'USD' );
                            $text = "Nigerian ASFI Member With Discount Code to Pay $".number_format($with_code, 2);
                        }else{
                            $paymentContent = array('paymentPrice' => $nigerian_members,'Text' => 'Nigerian ASFI Member to Pay ','currency' => 'NGN');
                            $text = "Nigerian ASFI Member to Pay ₦".number_format($nigerian_members, 2);
                        }
                    }else{
                        if(!empty($Discount_avaliable)){
                            $paymentContent = array('paymentPrice' => $nigerian_with_code,'Text' => 'Nigerian ASFI Non-Member is free','currency' => 'NGN' );
                            $text = "Nigerian ASFI Non-Member With Discount Code to Pay ₦".number_format($nigerian_with_code, 2);
                        }else{
                            $paymentContent = array('paymentPrice' => $nigerian_non_member,'Text' => 'Nigerian ASFI Non-Member to Pay', 'currency' => 'NGN' );
                            $text = "Nigerian ASFI Non-Member to Pay ₦".number_format($nigerian_non_member, 2);
                        }

                    }
                }else{
                    if($membership === 'YES'){
                        if(!empty($Discount_avaliable)){
                            $paymentContent = array( 'paymentPrice' => $with_code,'Text' => 'African ASFI Member With Discount Code is free ', 'currency' => 'USD' );
                            $text = "African ASFI Member With Discount Code to Pay $".number_format($with_code, 2);
                        }else{
                            $paymentContent = array('paymentPrice' => $african_members, 'Text' => 'African ASFI Member to Pay ', 'currency' => 'USD' );
                            $text = "African ASFI Member to Pay $".number_format($african_members, 2);
                        }
                    }else{
                        if(!empty($Discount_avaliable)){
                            $paymentContent = array( 'paymentPrice' => $with_code,'Text' => 'African ASFI Non-Member With Discount Code is free ', 'currency' => 'USD' );
                            $text = "African ASFI Non-Member With Discount Code to Pay $".number_format($with_code, 2);
                        }else{
                            $paymentContent = array('paymentPrice' => $african_non_members,'Text' => 'African ASFI Non-Member to Pay ', 'currency' => 'USD' );
                            $text = "African ASFI Non-Member to Pay $".number_format($african_non_members, 2);
                        }

                    }
                }
            }else{
                if(!empty($Discount_avaliable)){
                    $paymentContent = array( 'paymentPrice' => $with_code,'Text' => 'Non-African registrar With Discount Code is free ', 'currency' => 'USD' );
                    $text = "African ASFI Non-Member With Discount Code to Pay $".number_format($with_code, 2);
                }else{
                    $paymentContent = array( 'paymentPrice' => $outside_africa, 'Text' => 'Non-African registrar to Pay ', 'currency' => 'USD' );
                    $text = "Non-African registrar to Pay $".number_format($outside_africa, 2);
                }
            }


            $paymentContent = json_encode($paymentContent,JSON_FORCE_OBJECT);



            $message = "
               <html>
                <p>Dear $firstname</p>

                <p>Thank you for your application to the course in $course_title, organized by the African Science Frontiers Initiatives (ASFI).</p>
                
                <p>This is to notify you that we have received your application. If you have not yet paid the course fee, please use the relevant link that pertains to you below to make your payment. If however you would need an invoice to facilitate a wire transfer, please write to us in a reply email and we will provide that.</p>
                
                <p>Payment links:&nbsp;</p>
                
                <p>$text </p>
                <p><a href='https://africansciencefrontiers.com/payment-page.php?SubmitCode=$Submitcode'>Click Here To Make Payment</a></p>
                
                <p>All applications will be processed after the application deadline and all applicants will be informed of the outcome latest 2 weeks before the start of the course.</p>
                
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
                $query = $db->query("INSERT INTO course_registration (course_reg_firstname, course_reg_surname, course_reg_email, course_reg_gender, course_reg_age, course_reg_affiliate, course_reg_country_origin, course_reg_country_residence, course_reg_position, course_reg_highest_degree, course_reg_degree_progress, course_reg_research_interest, course_reg_current_project, course_reg_prev_asfi_course, course_reg_course_id, membership_number, course_reg_title, course_reg_motivation, paymentContent, submitCode, course_reg_date) 
                                                 VALUES('$firstname', '$surname', '$email', '$gender', '$age', '$affiliation', '$country_origin', '$country_residence', '$current_position', '$highest_degree', '$Degree_progress', '$research_interest', '$current_project', '$prev_asfi_course', '$course_id', '$membership_number', '$course_title', '$why_interested', '$paymentContent ', '$Submitcode', CURRENT_TIMESTAMP)");
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
                        
                        $mail->setFrom('courses@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                        $mail ->AddAddress($email);
                        
                        //Name is optional
                        $mail->addReplyTo('info@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                    
                    
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Course Application Successful';
                        $mail->Body    = $message;

                        $mail->send();
                            $_SESSION['alert'] = "Hello $firstname, Your Course Registration was successful.  $text . Please Click Ok to continue to the payment Link.";
                            $_SESSION['alert_code'] = "success";
                            $_SESSION['alert_link'] = 'payment-page.php?SubmitCode='.$Submitcode;	
                    } catch (Exception $e) {
                            $_SESSION['alert'] = "Hello $firstname, Your Course Registration was successful. $text . Please Click Ok to continue to the payment Link.";
                            $_SESSION['alert_code'] = "warning";
                            $_SESSION['alert_link'] = 'payment-page.php?SubmitCode='.$Submitcode;
                    }

                   
                }else{
                    $_SESSION['alert'] = "Course Registration Not successfully. Please Try Again";
                    $_SESSION['alert_code'] = "error";
                    $_SESSION['alert_link'] = "";
                }
            }
            
        }
    }else{
        header('Location: courses.php');
        exit();	
    }
?>
<title><?=$course_title?> || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1><?=$course_title?> </h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li><a class="home" href="courses.php">Courses</a></li>
                    <li><?=$course_title?> </li>
                </ul>
            </div>
        </div>
    </section>
   

     <!-- Causes Details -->
     <div class="sidebar-page-container cause-details">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-8 content-column">
                    <div class="image mb-50"><img src="admin/img/courses/<?=$course_image?>" width="100%" alt=""></div>
                    <div class="sec-title mb-40">
                        <h1>Course description</h1>
                        <div class="text"><?=$course_details?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="feature-block-three">
                                <div class="inner-box">
                                    <div class="icon-box"><span class="flaticon-lgtb-1"></span></div>
                                    <h4>Target Groups: </h4>
                                    <div class="text"><?=$course_target?></div>
                                </div>
                            </div>
                            <div class="feature-block-three">
                                <div class="inner-box">
                                    <div class="icon-box"><span class="flaticon-shop-1"></span></div>
                                    <h4>Duration:</h4>
                                    <div class="text"><?=$course_duration?></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <?php if(!empty($course_video_link)){ ?>
                    <div class="sec-title">
                        <h1>What previous participants said:</h1>
                    </div> 
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="video-box"><img width="100%" src="admin/img/courses/<?=$course_image?>" alt=""><a href="<?=$course_video_link?>" class="overlay-link lightbox-image video-fancybox"><span class="flaticon-multimedia-1"></span></a></div>
                        </div>
                    </div>
                    <?php } ?>
                    <br>
                <?php if($course_status ==='active'){ ?>
                    <div class="donate-form-area" id="form">
                        <div class="donate-form-wrapper">
                            <div class="sec-title">
                                <h1>Register For the Course Below</h1>
                                <div class="text">ASFI Course Registration Form Questions</div>
                            </div>

                            <form  action="" method="post" class="donate-form default-form">
                                <h3> Information</h3>
                                
                                <div class="contact-form">
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="firstname" placeholder="First name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="surname" placeholder="Surname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="Email Address" required>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <select class="filters-selec form-controlt selectmenu" name="gender" required>
                                                    <option value="*">Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <select class="filters-selec form-controlt selectmenu" name="age" required>
                                                    <option value="*">Age</option>
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
                                                <input type="text" name="affiliation" placeholder="Affiliation">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <select name="country_origin" class=" form-controlt" id="myCountry" onchange="myCountryFunction()" required>
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
                                                    <option value="Iran">Iran</option>
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
                                                    <option value="Tanzania">Tanzania</option>
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
                                                <select name="country_residence" class=" form-controlt" id="myCountry" onchange="myCountryFunction()" required>
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
                                                    <option value="Iran">Iran</option>
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
                                                    <option value="Tanzania">Tanzania</option>
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
                                                <input type="text" name="current_position" placeholder="Current position" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="highest_degree" placeholder="Highest degree completed" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="Degree_progress" placeholder="Degree in progress" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="research_interest" placeholder="What is your research interest?">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="current_project" placeholder="What is the topic of your current project?">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <select class="filters-selec form-controlt selectmenu" name="prev_asfi_course">
                                                    <option value="*">Have you attended any ASFI courses previously? </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="remember-text">
                                                <div class="checkbox">
                                                <p><b>Are You a Member Of ASFI?</b></p>
                                                    <label>
                                                        <input name="membership" value="YES" type="radio" required>
                                                        <span><b>Yes</b></span>
                                                    </label>
                                                    <label>
                                                        <input name="membership" value="NO" type="radio" >
                                                        <span><b>No</b></span>
                                                    </label>
                                                </div>  
                                            </div>
                                        </div> 

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="membership_number" placeholder="If “Yes”, please include your unique ASFI Membership Number here">
                                            </div>
                                        </div>
                                       
                                        <div class="col-xl-12">
                                            <div class="remember-text">
                                                <div class="checkbox">
                                                <p><b>Do you have a Discount Code given by your association/institution</b></p>
                                                    <label>
                                                        <input name="discount_code_q" value="YES" type="radio" required>
                                                        <span><b>Yes</b></span>
                                                    </label>
                                                    <label>
                                                        <input name="discount_code_q" value="NO" type="radio" >
                                                        <span><b>No</b></span>
                                                    </label>
                                                </div>  
                                            </div>
                                        </div> 
                 
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" name="discount_code" placeholder="If “Yes”, please include the code here ">
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <textarea placeholder="Please give a short motivation for your interest in this course?" name="why_interested" id="" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <select class="filters-selec form-controlt selectmenu" name="">
                                                    <option value="*">How did you learn about this course </option>
                                                    <option value="ASFI email list">ASFI email list</option>
                                                    <option value="ASFI Research Tips and Tricks workshop">ASFI Research Tips and Tricks workshop</option>
                                                    <option value="ASFI Science Seminar Series">ASFI Science Seminar Series</option>
                                                    <option value="ASFI Website">ASFI Website</option>
                                                    <option value="ASFI Twitter">ASFI Twitter</option>
                                                    <option value="Colleague / Friend">Colleague / Friend</option>
                                                    <option value="Others">Others</option>
                                                </select>
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
                <?php }else{?>
                    <div class="sec-title">
                        <h1>THIS COURSE IS NOT CURRENTLY ACCEPTING APPLICATION</h1>
                    </div>
                <?php } ?>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Search Widget -->
                        <div class="sidebar-title">
                            <h4>Search</h4>
                        </div>
                        <div class="sidebar-widget search-box">
                            <form method="post" action="#">
                                <div class="form-group">
                                    <input type="search" name="search-field" value="" placeholder="Search...." required="">
                                    <button type="submit"><span class="flaticon-magnifying-glass"></span></button>
                                </div>
                            </form>
                        </div>
                        <!-- Cause Widget -->
                        <div class="sidebar-title">
                            <h4>Other Courses</h4>
                        </div>
                        <div class="sidebar-widget case-widget">
                            <div class="single-item-carousel owl-theme owl-carousel owl-nav-none owl-dot-style-one">
                            <?php 
                                $result_courses = $db->query("SELECT * FROM `courses` LIMIT 6 ");
                                while($courses = $result_courses->fetch_assoc()):
                            ?>  
                               
                                <div class="cause-block-two">
                                    <div class="inner-box">
                                        <div class="image">
                                            <img src="admin/img/courses/<?=$courses['course_image']?>" alt="">
                                            <div class="overlay">
                                                <a href="course-details.php?course_id=<?=$courses['course_id']?>" class="theme-btn btn-style-seven"><span style="color:#fff;">Course Details</span></a>
                                            </div>
                                        </div>
                                        <div class="lower-content">
                                            <!--Progress Levels-->
                                            <div class="progress-levels style-two">
                                            </div>
                                            <div class="wrapper-box">
                                                <h4><a href="course-details.php?course_id=<?=$courses['course_id']?>"><?=$courses['course_title']?></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php  endwhile;?>

                            </div>
                        </div>
                        <!-- Event Widget -->
                        <div class="sidebar-title">
                            <h4>Upcoming Events</h4>
                        </div>
                        <div class="sidebar-widget event-widget">
                        <?php $result_events = $db->query("SELECT * FROM events WHERE event_date >= CURRENT_DATE()  ORDER BY event_date DESC LIMIT 3"); 
                                 while($events = $result_events->fetch_assoc()): 
                                    $date_event = date_create($events['event_date']);
                        ?>
                            <div class="event-item">
                                <div class="image"><img style="border-radius:30%;" src="admin/img/events/<?=$events['event_image']?>" width="25%"  alt=""></div>
                                <div class="content">
                                    <div class="date"><?php echo date_format($date_event, 'j');?> <?php echo date_format($date_event, 'F');?>, <?php echo date_format($date_event, 'Y');?></div>
                                    <h5><a href="events-details.php?event_id=<?=$events['event_id']?>"><?=$events['event_title']?></a></h5>
                                </div>
                            </div>
                            <?php endwhile ?>                          
                        </div>
                        <!-- Newsletter Widget -->
                        <div class="sidebar-title">
                            <h4>Subscribe Us</h4>
                        </div>
                        <div class="sidebar-widget newsletter-widget-three">
                            <div class="inner-content">
                                <div class="text">Subscribe us and get latest news and <br>upcoming events.</div>
                                <form action="#">
                                    <input type="email" placeholder="Email Address...">
                                    <button class="theme-btn btn-style-two text-center"><span>Subscribe Us</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include_once('footer.php');?>