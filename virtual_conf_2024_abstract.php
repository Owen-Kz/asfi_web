<?php include_once('header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['submit_course_reg'])){
        
    $presenter_biography = $_POST['presenter_biography'];
    $presenter_biography = strip_tags($presenter_biography);
    $presenter_biography = $db->real_escape_string($presenter_biography);
    
    $State_of_study = $_POST['State_of_study'];
    $State_of_study = strip_tags($State_of_study);
    $State_of_study = $db->real_escape_string($State_of_study);
    
    $presentation_type = $_POST['presentation_type'];
    $presentation_type = strip_tags($presentation_type);
    $presentation_type = $db->real_escape_string($presentation_type);

    $theme = $_POST['theme'];
    $theme = strip_tags($theme);
    $theme = $db->real_escape_string($theme);
    
    $special_request = $_POST['special_request'];
    $special_request = strip_tags($special_request);
    $special_request = $db->real_escape_string($special_request);

    $title = $_POST['title'];
    $title = strip_tags($title);
    $title = $db->real_escape_string($title);
    
    $author = $_POST['author'];
    $author = strip_tags($author);
    $author = $db->real_escape_string($author);

    $affliliation = $_POST['affliliation'];
    $affliliation = strip_tags($affliliation);
    $affliliation = $db->real_escape_string($affliliation);

    $author_email = $_POST['author_email'];
    $author_email = strip_tags($author_email);
    $author_email = $db->real_escape_string($author_email);
    
    $abstract = $_POST['abstract'];
    $abstract = strip_tags($abstract);
    $abstract = $db->real_escape_string($abstract);

    $gender = $_POST['gender'];
    $gender = strip_tags($gender);
    $gender = $db->real_escape_string($gender);

    $author_title = $_POST['author_title'];
    $author_title = strip_tags($author_title);
    $author_title = $db->real_escape_string($author_title);
    
    $country_origin = $_POST['country_origin'];
    $country_origin = strip_tags($country_origin);
    $country_origin = $db->real_escape_string($country_origin);

    $country_residence = $_POST['country_residence'];
    $country_residence = strip_tags($country_residence);
    $country_residence = $db->real_escape_string($country_residence);

    $highest_degree = $_POST['highest_degree'];
    $highest_degree = strip_tags($highest_degree);
    $highest_degree = $db->real_escape_string($highest_degree);
    
    $wphone_number = $_POST['wphone_number'];
    $wphone_number = strip_tags($wphone_number);
    $wphone_number = $db->real_escape_string($wphone_number);

    $presenter = $_POST['presenter'];
    $presenter = strip_tags($presenter);
    $presenter = $db->real_escape_string($presenter);
    
    $keywords = $_POST['keywords'];
    $keywords = strip_tags($keywords);
    $keywords = $db->real_escape_string($keywords);

    $lateBreaker = $_POST['lateBreaker'];
    $lateBreaker = strip_tags($lateBreaker);
    $lateBreaker = $db->real_escape_string($lateBreaker);

    $message = "
    <html>
        <p>Dear $presenter</p>

        <p>Thank you for submitting your abstract to the 2nd ASFI Virtual Multidisciplinary Conference and Boot Camp. This email is to confirm that we have received your abstract and it is being given maximum attention by the conference abstract review committee. As indicated in the call for abstract, all abstract authors will be informed about the decision on their abstract by 31st August 2024.</p>
        
        <p>Meanwhile, registration to the conference opens on 15th June 2024, with further information below, including the registration link:</p>
        
        <ul>
            <li>Early Bird (15th June – 30th September 2024)</li>
            <li>ASFI Members: 10 USD</li>
            <li>Non-ASFI Members: 30 USD</li>
                <hr>
            <li>Late Registration (1st October – 26th November 2024)</li>
            <li>ASFI Members: 20 USD</li>
            <li>Non-ASFI Members: 50 USD</li>
                <hr>
            <li>Registration link: <a href='https://cutt.ly/reeFhYN8'>https://cutt.ly/reeFhYN8</a></li>
        </ul>
        <p>Please feel free to circulate information about the conference to your colleagues and your networks.</p>
        <p>Best wishes</p>
        
        <p>2nd ASFI Virtual Multidisciplinary Conference and Boot Camp Planning Committee <br />
        African Science Frontiers Initiatives<br />
        &quot;Raising the next generation of African scientists...&quot;<br />
        www.africansciencefrontiers.com<br />
        YouTube Channel: https://www.youtube.com/c/ASFIHubForResearchCapacityBuilding <br />
        Twitter: @AfricanScience2<br />
        LinkedIn: https://cutt.ly/IBhwv5o
        </p>
    </html>
    ";
    
    
    if(empty($author) || empty($abstract)){
                $_SESSION['alert'] = "Please Fill all Required Fields";
                $_SESSION['alert_code'] = "error";
                $_SESSION['alert_link'] = "virtual_conf_2024_abstract.php";
            
    }else{
        $query = $db->query("INSERT INTO `abstract` (`presenter`,`presenter_biography`, `presentation_type`, `State_of_study`, `theme`, `special_request`, `title`, `author`, `affliliation`, `abstract`, `date`, `author_email`, `gender`, `author_title`, `country_origin`, `country_residence`, `highest_degree`, `wphone_number`, `keywords`, `lateBreaker`)
        VALUES ('$presenter', '$presenter_biography', '$presentation_type', '$State_of_study', '$theme', '$special_request', '$title', '$author', '$affliliation', '$abstract', CURRENT_TIMESTAMP, '$author_email', '$gender', '$author_title', '$country_origin', '$country_residence', '$highest_degree', '$wphone_number','$keywords', '$lateBreaker')");
        
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
                   $mail ->AddAddress($author_email);
                   
                   //Name is optional
                   $mail->addReplyTo('conference2023@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
               
               
                   //Content
                   $mail->isHTML(true);                                  //Set email format to HTML
                   $mail->Subject = 'Abstract Submission Successful';
                   $mail->Body    = $message;

                   $mail->send();
                       $_SESSION['alert'] = "Hello $presenter, Your Abstract Submission was successful.";
                       $_SESSION['alert_code'] = "success";
                       $_SESSION['alert_link'] = 'virtual_conf_2024_abstract.php';	
               } catch (Exception $e) {
                       $_SESSION['alert'] = "Hello $presenter, Your Abstract Submission was successful.";
                       $_SESSION['alert_code'] = "warning";
                       $_SESSION['alert_link'] = 'virtual_conf_2024_abstract.php';
               }

        }else{
            $_SESSION['alert'] = "Unsuccessful Try again";
            $_SESSION['alert_code'] = "error";
            $_SESSION['alert_link'] = "virtual_conf_2024_abstract.php";
          
        }
    }
    
}


?>
<title>2nd ASFI Annual Virtual Multidisciplinary Conference and Boot Camp 2024  || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>2nd ASFI Annual Virtual Multidisciplinary Conference and Boot Camp 2024</h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Abstract Submission For The 2nd ASFI Annual Virtual Multidisciplinary Conference and Boot Camp 2024 </li>
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
                                   <!-- <img src="images/virtual-images/conf_abs.jpg" alt="" width="400px" title=""><br><br> -->
                                    <h1>THEME : REVOLUTIONIZING PERSPECTIVES: UNLEASHING INNOVATION IN AFRICAN RESEARCH</h1>
                                </div>
                                <div class="text">
                                    <h3 class="text-center" style="color:red;">Call for Abstract: Deadline 31st July 2024 </h3>
                                    <h3><b>Notification of Acceptance on abstracts will be communicated on 31st August 2024</b> </h3>
                                    <p>
                                        We are delighted to announce that abstract submission to the 2024 annual ASFI Conference and Boot Camp is now opened. 
                                    </p>
                                    <p>
                                        This conference will bring together researchers, scholars, practitioners, and innovators from diverse fields to explore new ways of thinking, collaborating, and conducting research in Africa. Participants will share their groundbreaking works and insights on how African research can be transformed through innovative approaches. 
                                    </p>
                                    <p>
                                        We welcome abstract submissions that explore new methodologies, technologies, perspectives, and results that emanate from use of such novel approaches that have the potential to revolutionize the research landscape in Africa.
                                    </p>
                                    <p>
                                         Join us in shaping the future of research in Africa by sharing your innovative ideas and contributing to the advancement of knowledge in the region.
                                    </p>
                                    <p>
                                        <b>
                                            Abstracts can be submitted on the following topic areas or other related areas on research innovation:
                                        </b>
                                    </p>
                                    <ol>
                                        <li> <b>1</b> &nbsp;&nbsp; Innovative research methodologies and approaches with application to Africa</li>
                                        <li> <b>2</b> &nbsp;&nbsp; Decolonizing research practices and knowledge production in Africa</li>
                                        <li> <b>3</b> &nbsp;&nbsp; Advancements in technology and digital innovation in African research</li>
                                        <li> <b>4</b> &nbsp;&nbsp; Interdisciplinary collaborations and partnerships in innovative research in Africa</li>
                                        <li> <b>5</b> &nbsp;&nbsp;Addressing global challenges through African-centered research perspectives</li>
                                        <li> <b>6</b> &nbsp;&nbsp;Indigenous knowledge systems and their role in shaping research agendas in Africa, ETC</li>
                                       
                                    </ul>
                                </div>
                                <div class="text">
                                    <h4>To submit your abstract, please follow the submission guidelines below.</h4>
                                    <ul style="list-style-type:disc;" >
                                        <li><b>**</b> &nbsp;&nbsp; Abstracts must be structured with the following sections: Objectives, Methods, Results, and Conclusions</li>
                                        <li><b>**</b> &nbsp;&nbsp; Abstracts must not exceed 300 words (excluding title, authors, and affiliations)</li>
                                        <li><b>**</b> &nbsp;&nbsp; All abstracts must be submitted in English</li>
                                        <li><b>**</b> &nbsp;&nbsp; Abstracts should be written in clear and concise language, avoiding jargons and technical terms where possible</li>
                                        <li><b>**</b> &nbsp;&nbsp; If your request for an oral presentation is not granted, you may be asked to switch to a poster category</li>
                                        <li><b>**</b> &nbsp;&nbsp; You can submit abstracts for completed works or works-in-progress. For completed works, concrete results must be included</li>
                                        <li><b>**</b> &nbsp;&nbsp; Priority will be given to abstracts focusing on the conference theme and sub-themes. However, abstracts outside the conference themes can also be considered</li>
                                        <li><b>**</b> &nbsp;&nbsp; One author can submit more than one abstract, but if there are large number of submissions, there may be limit to one approved abstract per author</li>
                                        <li><b>**</b> &nbsp;&nbsp; Abstracts that do not meet the guidelines may not be accepted</li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <form  action="" method="post" name="formValidate" id="formValidate" class="donate-form default-form">
                                <div class="contact-form">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="presenter"><b>NAME OF PRESENTER OR SUBMITING AUTHOR</b></label>
                                                <input type="text" id="presenter" name="presenter" required placeholder="Insert the Presenter's Full Name">
                                            </div>
                                        </div> 
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="author_email"><b>AUTHOR'S EMAIL</b></label>
                                                <input type="email" id="author_email" name="author_email" required placeholder="Insert the contact Email of Author">
                                            </div>
                                        </div> 
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                            <label for="presentation_type"><b>AUTHOR’S TITLE</b></label>
                                                <select class="form-controlt" name="author_title" required>
                                                    <option value="">Your Title</option>
                                                    <option value="Prof">Prof.</option>
                                                    <option value="Dr">Dr.</option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Mrs">Mrs.</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                            <label for="presentation_type"><b>GENDER</b></label>
                                                <select class="form-controlt" name="gender" required>
                                                    <option value="">Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
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
                                                <label for="wphone_number"><b>WHATSAPP NUMBER (including country code)</b></label>
                                                <input type="text" id="wphone_number" name="wphone_number" placeholder="Please Enter your WhatsApp Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="affliliation"><b>AUTHOR’S AFFILIATION(S)</b></label>
                                                <input type="text" id="affliliation" name="affliliation" required placeholder="Insert the affiliation(s) of the author(s) here">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="author"><b>NAME(S) OF CO-AUTHOR(S)</b></label>
                                                <input type="text" id="author" name="author" placeholder="Insert the name(s) of the co-author(s)">
                                            </div>
                                        </div> 
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="presenter_biography"><b>PRESENTER BIOGRAPHY (maximum 100 words)</b> </label>
                                                <textarea id="presenter_biography" name="presenter_biography" class="form-control textarea" required placeholder="Insert a brief biography of the presenting author here including name, academic background, current research interests, and any relevant professional experience (maximum 610 characters)"></textarea>
                                            </div>
                                        </div> 
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="title"><b>TITLE OF ABSTRACT</b></label>
                                                <input type="text" id="title" name="title" required placeholder="Insert the title of your proposed abstract here">
                                            </div>
                                        </div> 
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="presentation_type"><b>PRESENTATION TYPE</b></label>
                                                <select id="presentation_type" class="form-controlt" required name="presentation_type">
                                                    <option value="">=== Select Presentation Type ===</option>
                                                    <option value="Oral presentation">Oral presentation</option>
                                                    <option value="Poster presentation">Poster presentation</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="State_of_study"><b>STATUS OF STUDY</b></label>
                                                <select id="State_of_study" class="form-controlt" required name="State_of_study">
                                                    <option value="">=== Select Status Of Study ===</option>
                                                    <option value="Completed work">Completed work</option>
                                                    <option value="Work-in-Progress">Work-in-Progress</option>
                                                </select>
                                            </div>
                                        </div> 
                                       
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="theme"><b>THEME</b></label>
                                                <select id="theme" class="form-controlt" name="theme" required>
                                                    <option value="">=== Please choose a Theme ===</option>
                                                    <option value="Innovative research methodologies and approaches with application to Africa"> Innovative research methodologies and approaches with application to Africa </option>
                                                    <option value="Decolonizing research practices and knowledge production in Africa">Decolonizing research practices and knowledge production in Africa</option>
                                                    <option value="Advancements in technology and digital innovation in African research">Advancements in technology and digital innovation in African research</option>
                                                    <option value="Interdisciplinary collaborations and partnerships in innovative research in Africa">Interdisciplinary collaborations and partnerships in innovative research in Africa</option>
                                                    <option value="Addressing global challenges through African-centered research perspectives">Addressing global challenges through African-centered research perspectives</option>
                                                    <option value="Indigenous knowledge systems and their role in shaping research agendas in Africa">Indigenous knowledge systems and their role in shaping research agendas in Africa</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="special_request"><b>SPECIAL REQUESTS</b></label>
                                                <textarea id="special_request" name="special_request" class="form-control textarea" placeholder="If you have any special requests or requirements for your presentation, such as audiovisual equipment or accessibility needs, please include them here"></textarea>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="abstract"><b>ABSTRACT (Maximum 300 words)</b></label>
                                                <textarea id="abstract" name="abstract" col="100" row="50" class="form-control textarea required" placeholder=""></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="keywords"><b>KEYWORDS (Minimum of three and maximum of six keywords.)</b></label>
                                                <input type="text" id="keywords" name="keywords"  placeholder="Insert a list of keywords that describe your research and that accurately reflect the content of your abstract.">
                                            </div>
                                        </div>     
                                         <div class="col-lg-12 col-md-12 column">
                                            <div class="form-group">
                                                <label for="lateBreaker"><b> IMPLICATIONS OF THE RESEARCH FOR PRACTICE OR RESEARCh (maximum of 50 words)</b></label>
                                                <textarea id="lateBreaker" name="lateBreaker" col="100" row="20" class="form-control textarea " placeholder="Explain how your research or project can be applied in practice or contribute to further research in the field"></textarea>
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
        presenter:{
            minlength: 2,
            maxlength: 300
        },
        presenter_biography:{
            minlength: 10,
            maxlength: 500
        },
       
        special_request:{
            minlength: 10,
            maxlength: 500
        },
        title:{
            minlength: 10,
            maxlength: 300
        },
        author:{
            minlength: 2,
            maxlength: 300
        },
        author_email:{
            email:true
        },
        affliliation:{
            minlength: 2,
            maxlength: 300
        },
        
        abstract:{
            minlength: 10,
            maxlength: 1900
        },
        
        lateBreaker:{
            minlength: 10,
            maxlength: 900
        }
    },

    messages: {
        presenter_biography:{
            required: "Please Enter a brief biography",
            minlength: "Biography Must Be More than 10 Characters",
            maxlength: "Biography Must not Be More than 610 Characters"
        },

        presenter:{
            required: "Please Enter the Presenters Full Name",
            minlength: "Presenters Full Name Must Be More than 10 Characters",
            maxlength: "Presenters Full Name Must not Be More than 610 Characters"
        },
        
        special_request:{
            minlength: "Special Request Must Be More than 10 Characters",
            maxlength: "Special Request Must not Be More than 500 Characters"
        },
        title:{
            required: "Please Enter The Title For Your Abstract ",
            minlength: "Abstract Title Must Be More than 10 Characters",
            maxlength: "Abstract Title Must not Be More than 300 Characters"
        },
        author:{
            required: "Please Enter The Co-author(s) Of The Abstract ",
            minlength: "Abstract's Author(s) Must Be More than 2 Characters",
            maxlength: "Abstract Author(s) Must not Be More than 300 Characters"
        },
        author_email:"Please Enter Valid Email",
        affliliation:{
            required: "Please Enter The Affliliation(s) of the Author(s) Of The Abstract ",
            minlength: "Abstract's Author(s) Affliliation(s)  Must Be More than 2 Characters",
            maxlength: "Abstract Author(s) Affliliation(s)  Must not Be More than 300 Characters"
        },
        abstract:{
            required: "Please Enter The Abstract ",
            minlength: "Abstract Must Be More than 10 Characters",
            maxlength: "Abstract Must not Be More than 1900 Characters"
        },
        lateBreaker:{
            required: "Please Enter Please MOTIVATE why Your ABSTRACT is A LATE-BREAKING ABSTRACT ",
            minlength: "MOTIVATE Must Be More than 10 Characters",
            maxlength: "MOTIVATE Must not Be More than 900 Characters"
        }

       
      },

    submitHandler: function(form) {
        form.submit();
    }

   });
</script>