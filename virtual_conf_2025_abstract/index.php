<?php

session_start(); 
require_once __DIR__ . '/../../includes/spam_detector.php';
include ('../includes/db_connect.php');
include '../includes/load_env.php';
include '../includes/brevo.php';


  // Verify reCAPTCHA
  $secret = $_ENV['RECAPTCHA_SECRET_KEY'] ?? getenv('RECAPTCHA_SECRET_KEY');
$brevo_api_key = $_ENV['BREVO_API_KEY'] ?? getenv('BREVO_API_KEY');

  $response = $_POST['g-recaptcha-response'];
  $remoteip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['submit_course_reg'])){
    


  $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}&remoteip={$remoteip}");
  $responseData = json_decode($verify);
  
  if ($responseData->success) {
        
      $presenter_biography = $_POST['presenter_biography'];
      $presenter_biography = strip_tags($presenter_biography);
      $presenter_biography = $db->real_escape_string($presenter_biography);
      
      $State_of_study = $_POST['State_of_study'];
      $State_of_study = strip_tags($State_of_study);
      $State_of_study = $db->real_escape_string($State_of_study);
      
      $presentation_type = $_POST['presentation_type'];
      $presentation_type = strip_tags($presentation_type);
      $presentation_type = $db->real_escape_string($presentation_type);
    
      $theme = null;
      
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
    
      $lateBreaker = null;
    
      // Updated email content
      $message = "
      <html>
      <head>
        <title>Thank You for Submitting Your Abstract</title>
      </head>
      <body>
        <p>Dear $presenter,</p>

        <p>Thank you for submitting your abstract to the 3rd ASFI Virtual Multidisciplinary Conference and Boot Camp.</p>

        <p>This email is to confirm that we have received your abstract, and it is being given maximum attention by the conference abstract review committee.</p>

        <p>As indicated in the call for abstract, all abstract authors will be informed about the decision on their abstract by 30th September 2025 (for regular submissions) and by 15th October 2025 (for late breaking submissions).</p>

        <p>Meanwhile, registration for the conference is ongoing, with further information below, including the registration link:</p>
        
        <ul>
          <li><strong>Early Bird (15th July – 30th September 2025)</strong>
            <ul>
              <li>ASFI Members: 10 USD (N10,000)</li>
              <li>Non-ASFI Members: 30 USD (N30,000)</li>
            </ul>
          </li>
          <li><strong>Late Registration (1st October – 24th November 2025)</strong>
            <ul>
              <li>ASFI Members: 20 USD (N20,000)</li>
              <li>Non-ASFI Members: 50 USD (N50,000)</li>
            </ul>
          </li>
          <li><strong>Registration link:</strong> <a href='https://africansciencefrontiers.com/event_registration.php?event=12'>https://africansciencefrontiers.com/event_registration.php?event=12</a></li>
        </ul>

        <p>Please feel free to circulate information about the conference to your colleagues and your networks.</p>

        <p>Sincerely,<br />
        ASFI Virtual Multidisciplinary Conference and Boot Camp Planning Committee<br />
        African Science Frontiers Initiatives<br />
        &quot;Raising the Next Generation of African Scientists&quot;<br />
        🌐 Website: africansciencefrontiers.com<br />
        📺 YouTube: ASFI Hub<br />
        🐦 X: @AfricanScience2<br />
        🔗 LinkedIn: ASFI LinkedIn
        </p>
      </body>
      </html>
      ";
      
      $plain_text_message = "Dear $presenter,

Thank you for submitting your abstract to the 3rd ASFI Virtual Multidisciplinary Conference and Boot Camp.

This email is to confirm that we have received your abstract, and it is being given maximum attention by the conference abstract review committee.

As indicated in the call for abstract, all abstract authors will be informed about the decision on their abstract by 30th September 2025 (for regular submissions) and by 15th October 2025 (for late breaking submissions).

Meanwhile, registration for the conference is ongoing, with further information below, including the registration link:

Early Bird (15th July – 30th September 2025)
- ASFI Members: 10 USD (N10,000)
- Non-ASFI Members: 30 USD (N30,000)

Late Registration (1st October – 24th November 2025)
- ASFI Members: 20 USD (N20,000)
- Non-ASFI Members: 50 USD (N50,000)

Registration link: https://africansciencefrontiers.com/event_registration.php?event=12

Please feel free to circulate information about the conference to your colleagues and your networks.

Sincerely,
ASFI Virtual Multidisciplinary Conference and Boot Camp Planning Committee
African Science Frontiers Initiatives
\"Raising the Next Generation of African Scientists\"
Website: africansciencefrontiers.com
YouTube: ASFI Hub
X: @AfricanScience2
LinkedIn: ASFI LinkedIn";
      
      if(empty($author) || empty($abstract)){
          $_SESSION['alert'] = "Please Fill all Required Fields";
          $_SESSION['alert_code'] = "error";
          $_SESSION['alert_link'] = "virtual_conf_2024_abstract.php";
              
      }else{
          $query = $db->query("INSERT INTO `abstract` (`presenter`,`presenter_biography`, `presentation_type`, `State_of_study`, `theme`, `special_request`, `title`, `author`, `affliliation`, `abstract`, `date`, `author_email`, `gender`, `author_title`, `country_origin`, `country_residence`, `highest_degree`, `wphone_number`, `keywords`, `lateBreaker`)
          VALUES ('$presenter', '$presenter_biography', '$presentation_type', '$State_of_study', '$theme', '$special_request', '$title', '$author', '$affliliation', '$abstract', CURRENT_TIMESTAMP, '$author_email', '$gender', '$author_title', '$country_origin', '$country_residence', '$highest_degree', '$wphone_number','$keywords', '$lateBreaker')");
          
          if($query){
              // Use Brevo API to send email - read from environment variable
              
              // Prepare the email data for Brevo
              $email_data = [
                  'sender' => [
                      'name' => 'African Science Frontiers Initiatives (ASFI)',
                      'email' => 'conference2023@africansciencefrontiers.com'
                  ],
                  'to' => [
                      [
                          'email' => $author_email,
                          'name' => $presenter  // Fixed: Use presenter name instead of API key
                      ]
                  ],
                  'subject' => 'Thank You for Submitting Your Abstract to ASFI 3rd Annual Conference & Boot Camp',
                  'htmlContent' => $message,
                  'textContent' => $plain_text_message,
                  'replyTo' => [
                      'email' => 'conference2023@africansciencefrontiers.com',
                      'name' => 'African Science Frontiers Initiatives (ASFI)'
                  ]
              ];
              
              // Send email using Brevo API
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email_data));
              curl_setopt($ch, CURLOPT_HTTPHEADER, [
                  'accept: application/json',
                  'api-key: ' . $brevo_api_key,
                  'content-type: application/json'
              ]);
              
              $result = curl_exec($ch);
              $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              curl_close($ch);
              
              if ($http_code >= 200 && $http_code < 300) {
                  // Email sent successfully
                  $_SESSION['alert'] = "Hello $presenter, Your Abstract Submission was successful. A confirmation email has been sent to $author_email.";
                  $_SESSION['alert_code'] = "success";
                  $_SESSION['alert_link'] = 'https://africansciencefrontiers.com/virtual_conf_2025_abstract';	
              } else {
                  // Email sending failed but abstract was saved
                  $_SESSION['alert'] = "Hello $presenter, Your Abstract Submission was successful but we couldn't send a confirmation email.";
                  $_SESSION['alert_code'] = "warning";
                  $_SESSION['alert_link'] = 'https://africansciencefrontiers.com/virtual_conf_2025_abstract';
              }
    
          }else{
              $_SESSION['alert'] = "Unsuccessful Try again";
              $_SESSION['alert_code'] = "error";
              $_SESSION['alert_link'] = "https://africansciencefrontiers.com/virtual_conf_2025_abstract";
            
          }
      }
      
    }else{
        $_SESSION['alert'] = "Captcha verification failed";
        $_SESSION['alert_code'] = "error";
        $_SESSION['alert_link'] = "https://africansciencefrontiers.com/virtual_conf_2025_abstract";
    }
}

if(isset($_POST['sub_email_submit'])){
        
  $sub_email = $_POST['sub_email'];
  $sub_email = strip_tags($sub_email);
  $sub_email= $db->real_escape_string($sub_email);
  

  
  if(empty($sub_email)){
      echo "<script>alert('Email Can not be Empty'); </script>";
  }else{
      $query = $db->query("INSERT INTO email_subscription (sub_email,date_sub)
                      VALUES('$sub_email', CURRENT_TIMESTAMP) ");
      
      if($query){
          echo "<script>alert('Your Email Subscription Successfull. We Will Keep In Touch with you'); </script>";
      }else{
          echo "<script>alert('Unsuccessful Try again'); </script>";
      }
  }
  
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>3rd ASFI Annual Virtual Multidisciplinary Conference and Boot Camp 2025  || African Science Frontiers Initiatives (ASFI)</title>

  <link rel="shortcut icon" href="images/icon/icon.png" type="image/x-icon">
  <link rel="icon" href="images/icon/icon.png" type="image/x-icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!--CSS Plugins-->
  <link rel="stylesheet" href="css/plugin.css">
  <!-- Default CSS-->
  <link rel="stylesheet" href="css/default.css">
  <!--Custom CSS-->
  <link rel="stylesheet" href="css/styles.css?v=1.0.0">
  <!-- AOS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

  <!--FontAwesome CSS-->
  <link rel="stylesheet" href="icons/font-awesome.min.css">
  
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<body>
  <!--Header Section start-->
  <header class="main_header_area position-absolute w-100">

    <div class="header-content text-white">
      <div class="container">
        <div class="header-content-inner py-2">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="social-links ">
                <ul class="m-0 p-0">
                  <li class="d-inline">
                    <a target="_blank" href="https://www.facebook.com/groups/392075606316714/">
                      <i class="fa fa-facebook border-social rounded-circle text-center"></i>
                    </a>
                  </li>
                  <li class="d-inline">
                    <a target="_blank" href="https://twitter.com/AfricanScience2">
                      <i class="fa fa-twitter border-social rounded-circle text-center"></i>
                    </a>
                  </li>
                  <li class="d-inline">
                    <a target="_blank" href="https://www.linkedin.com/in/african-science-frontiers-initiatives-asfi-74967b240/">
                      <i class="fa fa-linkedin border-social rounded-circle text-center"></i>
                    </a>
                  </li>
                  <li class="d-inline">
                    <a target="_blank" href="https://www.instagram.com/asfi_africa/">
                      <i class="fa fa-instagram border-social rounded-circle text-center"></i>
                    </a>
                  </li>
                  <li class="d-inline">
                    <a target="_blank" href="https://www.youtube.com/c/ASFIHubForResearchCapacityBuilding">
                      <i class="fa fa-youtube-play border-social rounded-circle text-center "></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="header-event-info text-end">
                <ul class="m-0 p-0">
                  <li class="px-2 border-end border-lightgrey border-opacity-50 d-inline">
                    <i class="fa fa-phone pe-1"></i>
                    <small> +234(0) 701 436 3223</small>
                  </li>
                  <li class=" px-2 d-inline">
                    <i class="fa fa-envelope-o pe-1"></i>
                    <small>info@africansciencefrontiers.com</small>
                  </li>
                  <!-- <li class=" px-2 d-inline ">
                    <i class="fa fa-clock-o pe-1"></i>
                    <small>Mon - Fri: 9:00 - 18:30</small>
                  </li> -->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Bar -->
    <div class="header_menu " id="header_menu">
      <div class="container">
        <nav class="navbar navbar-expand-lg py-2">
          <div class="row">
            <div class="col-lg-2 col-md-6">
              <div class="navbar-brand m-0">
                 <a href="https://africansciencefrontiers.com/">
                <img src="images/logo/1.png" alt="Logo" class="w-100">
              </a>
              </div>
            </div>
            <div class="col-lg-7 col-md-6 ">
              <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
                <ul class="navbar-nav align-items-center" id="responsive-menu">
                  <li class="nav-item ">
                    <a class="nav-link px-2 my-4 py-0 text-white" aria-current="page" href="https://africansciencefrontiers.com/index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link px-2 my-4 py-0 text-white" href="https://africansciencefrontiers.com/about.php">About</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link px-2 my-4 py-0 text-white" href="#event-speakers" role="button"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      Speaker
                    </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link px-2 my-4 py-0 text-white" href="https://africansciencefrontiers.com/partnership.php" role="button">
                      Donations
                    </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-2 my-4 py-0 text-white" href="https://africansciencefrontiers.com/about.php" role="button"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      Activities
                    </a>
                    <ul class="dropdown-menu bg-lightgrey p-0 rounded">
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/courses.php">Courses & Workshops</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/virtual_conf_2025_abstract?event_id=12">2025 Virtual Conference</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/events-details.php?event_id=10">2024 Virtual Conference</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/AsfiWomenWeek2024.php">ASFI Women’s Week 2024</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/2023_virtual_conf_event_highlight.php">2023 Virtual Conference</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/ASFI_In_Number_2020-2022.php">ASFI In Numbers 2020-2022</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/ASFI_Impact_essays_2023.php">ASFI Impact Essays 2023 </a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="https://africansciencefrontiers.com/events-details.php?event_id=7">ASFI Science Seminar Series</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/events-details.php?event_id=6">Dr. Nwaru’s Research Tips & Tricks</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="https://africansciencefrontiers.com/mentoring_program.php">ASFI Mentoring Program</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="ASFIScholar.php">ASFIScholar</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link px-2 my-4 py-0 text-white" href="https://africansciencefrontiers.com/news.php" role="button">
                      News
                    </a>
                    <!-- <ul class="dropdown-menu bg-lightgrey p-0 rounded">
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="news-list.php">News List</a></li>
                      <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0"
                          href="news-single.php">News Single</a></li>
                    </ul> -->
                  </li>
                  <li class="nav-item">
                    <a class="nav-link px-2 my-4 py-0 text-white" href="https://africansciencefrontiers.com/contact.php">Contact</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="menu-search">
                <a href="#search1" class="mt_search">
                  <i class="fa fa-search fa-lg me-5 text-white"></i>
                </a>
                <a class="btn btn3" href="https://africansciencefrontiers.com/login.php">Sign in<i class="fa fa-long-arrow-right ms-4"></i></a>
              </div>
            </div>
            <div id="slicknav-mobile"></div>
          </div>
        </nav>
      </div>
      <div id="search1">
        <button type="button" class="close">×</button>
        <form>
          <input class="form-control form-control-lg rounded text-white" placeholder="Search...">
        </form>
        <button type="button" class="btn"><i class="fa fa-search text-white" aria-hidden="true"></i></button>
      </div>

    </div>
    <!-- Navigation Bar Ends -->
  </header>
  <!-- Header section ends -->

  <!-- Bannner section starts -->
  <section class="banner position-relative pb-0">
    <div class="overlay">
    </div>
    <div class="container">
      <div class="inner-banner position-relative text-white ">
        <div class="row">
          <div class="col-lg-6 order-2 order-lg-1">
            <div class="banner-left text-center pb-lg-5 p-md-0">
              <div data-aos="zoom-in" class="banner-image">
                <img src="images/team/lady.png" alt="banner-image" class="w-50"><br>
              </div>
              <div class="countdown">
                <div id="countdown"
                  class="countdown-inner d-flex w-100 bg-white p-2 rounded-5 justify-content-center box-shadow position-relative z-2">
                  <div class="time m-auto py-4 ">
                    <span id="days" class="lh-1 h1 fw-bold"></span><br>
                    <small class="text-secondary">Days</small>
                  </div>

                  <div class="time  m-auto py-4">
                    <span id="hours" class="lh-1 h1 fw-bold"></span><br>
                    <small class="text-secondary">Hours</small>
                  </div>

                  <div class="time  m-auto py-4">
                    <span id="minutes" class="lh-1 h1 fw-bold"></span><br>
                    <small class="text-secondary">Minutes</small>
                  </div>

                  <div class="time  m-auto py-4">
                    <span id="seconds" class="lh-1 h1 fw-bold"></span><br>
                    <small class="text-secondary">Seconds</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div data-aos="fade-up" class="col-lg-6 order-1 order-lg-2">
            <div class="banner-right  ms-2 text-center text-lg-start pb-8">
              <div class="banner-title pb-3">
                <h4 class="text-white pb-3">UPCOMING NEW <span class="pink">EVENT</span> 2025</h4>
                <h1 class="text-white">ASFI <span class="pink">MULTI-DISCIPLINARY</span> CONFERENCE</h1>
              </div>
              <div class="banner-event-info pb-3">
                <ul class="m-0 ps-0 d-sm-flex justify-content-center justify-content-lg-start list-unstyled">
                  <li class="pe-2 border-end border-1 border-lightgrey">
                    <i class="fa  fa-calendar-o pe-1"></i> 25-27 NOV 2025
                  </li>
                  <li class="ps-2">
                    <i class="fa  fa-map-marker pe-1"></i> VIRTUAL, DETAILS VIA EMAIL
                  </li>
                </ul>
              </div>
              <div class="event-discription">
                <!--<p class="pb-4 m-0">Abstract Submission For The 3rd ASFI Annual Virtual Multidisciplinary Conference and Boot Camp 2025</p>-->
                <div class="banner-button">
                  <div class="row">
                    <div class="col-lg-6 col-md-6">
                      <a class="btn me-3 my-1 w-100" href="#abstract-form-section">SUBMIT ABSTRACT</a>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <a class="btn btn2 my-1 w-100" href="https://africansciencefrontiers.com/event_registration.php?event=12">EVENT REGISTRATION</a>
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wave overflow-hidden position-absolute w-100 z-0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none"
        class="d-block position-relative">
        <path class="elementor-shape-fill" d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3
          c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3
          c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z"></path>
      </svg>
    </div>
  </section>
  <!--Banner Section end-->

  <!--Overview Section start-->
  <section data-aos="fade-up" class="overview pb-0">
    <div class="container">
      <div class="inner-overview pb-10 position-relative border-dashed-bottom-2">
        <div class="row">
          <div class="col-lg-6">
            <div class="overview-left text-center text-lg-start">
              <div class="overview-title pb-4">
                <p class="mb-1 pink">THEME</p>
                <h2><span class="pink">BEYOND BOUNDARIES:</span> BREAKING COLLABORATIVE FRONTIERS FOR IMPACTFUL RESEARCH AND CAREER</h2>
                <p>ASFI proudly presents its 3rd Annual Virtual Multidisciplinary Conference & Boot Camp under the unifying banner of advancing Africa’s scientific collaboration, innovation, and policy influence.</p>
                <!-- <p>This year’s conference convenes researchers, policymakers, innovators, and thought leaders from across the continent and diaspora to reimagine Africa’s scientific future through strategic partnerships and shared knowledge ecosystems.</p> -->
              </div>
              <div class="overview-event-info pb-6 g-4 text-start position-absolute">
                <div class="row justify-content-around ">
                  <div class="col-lg-6 col-md-6">
                    <a>
                      <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                        <div class="event-info-icon text-center ">
                          <i class="fa fa-map-marker  text-white bg-pink rounded-circle me-3"></i>
                        </div>
                        <div class="location-info">
                          <h5 class="mb-1">WHERE</h5>
                          <small>Virtual (Streaming Live, Join from Anywhere)</small>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <a>
                      <div class="event-info-box align-items-center d-flex p-4 rounded bg-white box-shadow my-2">
                        <div class="event-info-icon text-center">
                          <i class="fa fa-calendar-o  text-white bg-pink rounded-circle me-3"></i>
                        </div>
                        <div class="time-info">
                          <h5 class="mb-1">WHEN</h5>
                          <small>Tuesday To Thursday <br> 25-27 Nov, 2025</small>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="overview-img">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 p-0 ">
                  <div class="container-img-left mb-2">
                    <div class="img-left-1 float-end w-lg-80">
                      <img class="mb-2 w-100 rounded" src="images/group/1.jpg" alt="group-image">
                    </div>
                    <div class="img-left-2">
                      <img src="images/group/2.jpg" alt="group-image" class="w-100 rounded">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <div class="container-img-right w-lg-75">
                    <img src="images/group/3.jpg" alt="group-image" class="w-100 rounded">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Overview Section end-->

  <!--Speakers Section Start-->
  <section data-aos="fade-up" class="speakers" id="event-speakers">
    <div class="container">
      <div class="speaker-inner">
        <div class="speaker-title text-center p-2">
          <div class="row align-items-center ">
            <div class="col-lg-6">
              <div class="title-content  text-lg-start mb-2">
                <p class="mb-1 pink">EVENT SPEAKERS</p>
                <h2 class="mb-1">MEET OUR <span class="pink">SPEAKERS</span></h2>
                <p class="m-0">Get to know the experts, innovators, and thought
                  leaders who will be sharing their insights at our event.
                  <span class="pink">Speakers will be announced soon. Stay tuned!</span>
                </p>
              </div>
            </div>
            <!-- <div class="col-lg-6">
              <div class="speaker-button text-lg-end">
                <a class="btn my-2" href="speaker_list.html">VIEW MORE SPEAKERS</a>
              </div>
            </div> -->
          </div>
        </div>
        <div class="sepaker-list text-center text-white">
          <div class="row">
            <div class=" col-lg-3 col-md-6 p-2">
              <div class="speaker-box  position-relative overflow-hidden text-white">
                <img class="speaker-image rounded w-100" src="images/team/5.png" alt="speaker-image">
                <div class="box-content position-absolute bottom-0 z-1">
                  <h6 class="speaker-title d-block text-white pb-1"><a href="#">TO BE ANNOUNCED</a>
                  </h6>
                  <span class="speaker-post d-block pb-2">Details Coming Soon</span>
                  <ul class="social-link pb-2 ps-0">
                    <li class="d-inline-block"><a href="#" class="rounded d-block me-1"><i
                          class="fa fa-facebook"></i></a></li>
                    <li class="d-inline-block"><a href="#" class="rounded d-block me-1"><i
                          class="fa fa-twitter"></i></a></li>
                    <li class="d-inline-block"><a href="#" class="rounded d-block me-1"><i
                          class="fa fa-pinterest-p"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class=" col-lg-3 col-md-6 p-2">
              <div class="speaker-box position-relative overflow-hidden">
                <img class="speaker-image rounded w-100" src="images/team/4.png" alt="speaker-image">
                <div class="box-content position-absolute bottom-0 z-1">
                  <h6 class="speaker-title d-block text-white pb-1"><a href="#">TO BE ANNOUNCED</a>
                  </h6>
                  <span class="speaker-post d-block pb-2">Details Coming Soon</span>
                  <ul class="social-link pb-2 ps-0 position-relative">
                    <li class="d-inline-block"><a href="#" class="rounded d-block me-1"><i
                          class="fa fa-facebook"></i></a></li>
                    <li class="d-inline-block"><a href="#" class="rounded d-block me-1"><i
                          class="fa fa-twitter"></i></a></li>
                    <li class="d-inline-block"><a href="#" class="rounded d-block me-1"><i
                          class="fa fa-pinterest-p"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 p-2">
              <div class="speaker-box position-relative overflow-hidden">
                <img class="speaker-image rounded w-100" src="images/team/5.png" alt="speaker-image">
                <div class="box-content position-absolute bottom-0 z-1">
                  <h6 class="speaker-title d-block text-white pb-1"><a href="#">TO BE ANNOUNCED</a>
                  </h6>
                  <span class="speaker-post d-block pb-2">Details Coming Soon</span>
                  <ul class="social-link pb-2 ps-0">
                    <li class="d-inline-block"><a href=" " class="rounded  d-block me-1"><i
                          class="fa fa-facebook"></i></a></li>
                    <li class="d-inline-block"><a href=" " class="rounded  d-block me-1"><i
                          class="fa fa-twitter"></i></a></li>
                    <li class="d-inline-block"><a href=" " class="rounded  d-block me-1"><i
                          class="fa fa-pinterest-p"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 p-2">
              <div class="speaker-box position-relative overflow-hidden">
                <img class="speaker-image rounded w-100" src="images/team/4.png" alt="speaker-image">
                <div class="box-content position-absolute bottom-0 z-1">
                  <h6 class="speaker-title d-block text-white pb-1"><a href="#">TO BE ANNOUNCED</a>
                  </h6>
                  <span class="speaker-post d-block pb-2">Details Coming Soon</span>
                  <ul class="social-link pb-2 ps-0">
                    <li class="d-inline-block"><a href="#" class="rounded  d-block me-1"><i
                          class="fa fa-facebook"></i></a></li>
                    <li class="d-inline-block"><a href="#" class="rounded  d-block me-1"><i
                          class="fa fa-twitter"></i></a></li>
                    <li class="d-inline-block"><a href="#" class="rounded  d-block me-1"><i
                          class="fa fa-pinterest-p"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Speakers Section end-->

  <!--Topics Section start-->
  <section data-aos="fade-up" class="feature text-white position-relative z-0 start-0">
    <div class="overlay z-n1">
    </div>
    <div class="container">
      <div class="feature-inner">
        <div class="text-center">
          <h2 class="text-white mb-1">Event <span class="pink">Sub-themes</span></h2>
          <p class="text-white mb-0">The event is anchored on four interlinked sub-themes.</p>
        </div>
        <div class="feature-lists pt-8 mb-6">
          <div class="row g-4">
            <div data-aos="zoom-in" class="col-lg-3 col-md-6">
              <div class="feature-box py-7 px-6 rounded text bg-black bg-opacity-25">
                <a onclick="controller.showModal('topic-1')">
                  <div class="feature-box-icon mb-4">
                    <i class="fa fa-unlock text-white bg-pink rounded-circle text-center"></i>
                  </div>
                  <div class="feature-box-info ">
                    <h5 class="text-white pink mb-2">BREAKING BARRIERS, BUILDING BRIDGES</h5>
                    <small>
                      Overcoming impediments to African collaboration and unity
                    </small>
                  </div>
                </a>
              </div>
            </div>
            <div data-aos="zoom-in" class="col-lg-3 col-md-6">
              <div class="feature-box py-7 px-6 rounded  bg-black bg-opacity-25">
                <a onclick="controller.showModal('topic-2')">
                  <div class="feature-box-icon mb-4">
                    <i class="fa fa-users text-white bg-pink rounded-circle text-center"></i>
                  </div>
                  <div class="feature-box-info">
                    <h5 class="text-white mb-2">FROM COLLABORATION TO IMPACT</h5>
                    <small>
                      Scaling African-led solutions through strategic partnerships
                    </small>
                  </div>
                </a>
              </div>
            </div>
            <div data-aos="zoom-in" class="col-lg-3 col-md-6">
              <div class="feature-box py-7 px-6 rounded bg-black bg-opacity-25">
                <a onclick="controller.showModal('topic-3')">
                  <div class="feature-box-icon mb-4">
                    <i class="fa fa-globe text-white bg-pink rounded-circle text-center"></i>
                  </div>
                  <div class="feature-box-info">
                    <h5 class="text-white mb-2">AFRICA'S RESEARCH AND INNOVATION ECOSYSTEM</h5>
                    <small>
                      The role of pan-continental networks
                    </small>
                  </div>
                </a>
              </div>
            </div>
            <div data-aos="zoom-in" class="col-lg-3 col-md-6">
              <div class="feature-box py-7 px-6 rounded bg-black bg-opacity-25">
                <a onclick="controller.showModal('topic-4')">
                  <div class="feature-box-icon mb-4">
                    <i class="fa fa-database text-white bg-pink rounded-circle text-center"></i>
                  </div>
                  <div class="feature-box-info">
                    <h5 class="text-white mb-2">DATA AND DECISION MAKING</h5>
                    <small>
                      Strengthening evidence-based policy engagements using data
                    </small>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div data-aos="zoom-in" class="text-center">
          <a class="btn btn1" href="#abstract-form-section">SUBMIT ABSTRACT NOW</a>
        </div>
      </div>
    </div>
  </section>
  <!--Topic Section end-->

  <!--Abstract Section end--> 
  <section data-aos="fade-up" class="contact">
    <div class="container">
      <div class="contact-inner text-center text-md-start">
        <div class="row g-md-5 gy-5 align-items-center">
          <div class="col-lg-4 col-md-5">
            <div class="contact-event-info p-8 text-start text-white h-100 rounded bg-pink">
              <div class="event-venue pb-5">
                <h5 class="text-white pb-2">DEADLINE</h5>
                <p class="m-0">31st August 2025</p>
              </div>
              <div class="event-venue pb-5">
                <h5 class="text-white pb-2">ACCEPTANCE NOTICE</h5>
                <p class="m-0">Notification of Acceptance on abstracts will be communicated on 30th September 2025</p>
              </div>
              <div class="address pb-5">
                <h5 class="text-white pb-2">SUBMISSION GUIDELINES</h5>
                <div>
                  <p><i class="fa fa-arrow-right"></i> Abstracts can be structured or unstructured. Structured abstract should have the following headings: Background, Objectives, Methods, Results, Conclusions.</p>
                  <p><i class="fa fa-arrow-right"></i> Abstracts must not exceed 300 words (excluding title, authors, and affiliations)</p>
                  <p><i class="fa fa-arrow-right"></i> All abstracts must be submitted in English</p>
                  <p><i class="fa fa-arrow-right"></i> Abstracts should be written in clear and concise language, avoiding jargons and technical terms where possible</p>
                  <p><i class="fa fa-arrow-right"></i> If your request for an oral presentation is not granted, you may be asked to switch to a poster category</p>
                  <p><i class="fa fa-arrow-right"></i> You can submit abstracts for completed works or works-in-progress. For completed works, concrete results must be included</p>
                  <p><i class="fa fa-arrow-right"></i> One author can submit more than one abstract, but if there are large number of submissions, there may be limit to one approved abstract per author</p>
                  <p><i class="fa fa-arrow-right"></i> Abstracts that do not meet the guidelines may not be accepted</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-7" id="abstract-form-section">
            <div class="contact-form">
              <div class="form-title mb-4">
                <h2 class="mb-1">Submit <span class="pink">Abstract</span></h2>
                <p>We welcome the submission of abstracts that fall within or outside of the conference sub-themes, including quantitative, qualitative, basic, and applied research from any discipline.</p>
              </div>
              <div class="form">
                <form action="" method="post" name="abstract" id="abstract">
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <input required name="presenter" type="text" placeholder="Name of Presenter or Submitting Author" class="" title="Name of Presenter or Submitting Author">
                    </div>
                    <div class="col-lg-6 mb-3">
                      <input required name="author_email" type="email" placeholder="Author's email" required title="Author's email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <select required name="author_title" title="Select Author's title">
                        <option disabled selected>Select Author's title</option>
                        <option value="prof">Prof.</option>
                        <option value="dr.">Dr.</option>
                        <option value="mr.">Mr.</option>
                        <option value="mrs.">Mrs.</option>
                        <option value="miss">Miss</option>
                      </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <select required name="gender" title="Gender">
                        <option disabled selected>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <select required name="highest_degree" title="Select Your Highest Degree Earned">
                        <option disabled selected>Select Your Highest Degree Earned</option>
                        <option value="Phd">PhD</option>
                        <option value="Masters">Masters</option>
                        <option value="Bachelors">Bachelors</option>
                        <option value="MD">MD</option>
                        <option value="Others">Others</option>
                      </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <select required name="country_origin" id="author-country" title="Choose country of origin">
                        <option disabled selected>Choose country of origin</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <select required name="country_residence" id="author-residence" title="Choose country of residence">
                        <option disabled selected>Choose country of residence</option>
                      </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <input required name="wphone_number" type="tel" placeholder="Phone No. with country code (Whatsapp)" title="Phone No. with country code (Whatsapp)">
                    </div>
                  </div>
                  <div class="col-lg mb-3">
                    <input required name="affliliation" type="text" placeholder="Author's affiliation(s)" required title="Author's affiliation(s)">
                  </div>
                  <div class="col-lg mb-3">
                    <input required name="author" type="text" placeholder="Name(s) of co-author(s)" required title="Name(s) of co-author(s)">
                  </div>
                  <div class="message mb-3">
                    <textarea required name="presenter_biography" maxlength="610" placeholder="Presenter's Biography (610 characters max)" rows="4" title="Presenter's Biography (610 characters max)"></textarea>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <input required name="title" type="text" placeholder="Title of Abstract (Insert the title of your proposed abstract here)" required title="Title of Abstract (Insert the title of your proposed abstract here)">
                    </div>
                    <div class="col-lg-6 mb-3">
                      <input required name="keywords" type="text" placeholder="Keywords (Min. 3 - Max. 6 keywords)" required title="Keywords (Minimum of 3 and maximum of 6 keywords)">
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-lg-6 mb-3">
                      <select required name="presentation_type" title="Choose presentation type">
                        <option disabled selected>Choose presentation type</option>
                        <option value="Oral Presentation">Oral Presentation</option>
                        <option value="Poster Presentation">Poster Presentation</option>
                      </select>
                    </div>
                    <div class="col-lg-6 mb-3">
                      <select required name="State_of_study" title="status of study">
                        <option disabled selected>status of study</option>
                        <option value="completed">Completed Work</option>
                        <option value="in-progress">Work-in-progress</option>
                      </select>
                    </div>
                    <!-- <div class="col-lg-4 mb-3">
                      <select required name="theme" title="Choose theme">
                        <option disabled selected>Choose theme</option>
                        <option value="Innovative research methodologies and approaches with application to Africa"> Innovative research methodologies and approaches with application to Africa </option>
                        <option value="Decolonizing research practices and knowledge production in Africa">Decolonizing research practices and knowledge production in Africa</option>
                        <option value="Advancements in technology and digital innovation in African research">Advancements in technology and digital innovation in African research</option>
                        <option value="Interdisciplinary collaborations and partnerships in innovative research in Africa">Interdisciplinary collaborations and partnerships in innovative research in Africa</option>
                        <option value="Addressing global challenges through African-centered research perspectives">Addressing global challenges through African-centered research perspectives</option>
                        <option value="Indigenous knowledge systems and their role in shaping research agendas in Africa">Indigenous knowledge systems and their role in shaping research agendas in Africa</option>
                        <option value="others">Others</option>
                      </select>
                    </div> -->
                  </div>
                  <div class="message mb-3">
                    <textarea required name="special_request" maxlength="300" placeholder="Special Requests; If you have any special requests or requirements for your presentation, such as audiovisual equipment or accessibility needs, please include them here" rows="4" title="Special Requests (E.g A/V, Accessibility, etc.)"></textarea>
                  </div>
                  <div class="message mb-3">
                    <textarea required name="abstract" maxlength="3050" placeholder="Abstract (300 words max.). You can submit structured or unstructured abstract. Structured abstracts should have the following headings: Background, Objectives, Methods, Results, Conclusions." rows="4" title="Abstract (300 words max.). You can submit structured or unstructured abstract. Structured abstracts should have the following headings: Background, Objectives, Methods, Results, Conclusions."></textarea>
                  </div>
                  <!-- <div class="message mb-3">
                    <textarea required name="lateBreaker" placeholder="Explain how your research or project can be applied in practice or contribute to further research in the field" rows="4" title="Explain how your research or project can be applied in practice or contribute to further research in the field"></textarea>
                  </div> -->
                  <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="6LcEcsUrAAAAACd3CAtZIO54BjvF7viwD__b0vTB"></div>
                  </div>
                   <button name="submit_course_reg" class="btn" type="submit">Submit<i class="fa fa-long-arrow-right ms-3"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Abstract Section end--> 

  <!--Subscribe Section start-->
  <section data-aos="fade-up" class="subscribe py-4">
    <div class="container">
      <div class="subscribe-content">
        <div class="row">
          <div class="col-lg-6 align-self-center ">
            <div class="sub-left text-center text-lg-start py-2">
              <h4 class="text-white ">DON'T MISS OUR FUTURE UPDATES! GET SUBSCRIBED TODAY!</h4>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="sub-right py-2">
              <p class="text-white mb-4 text-center text-lg-start">Stay in the loop with the latest news, event updates,
                and exclusive content. Subscribe now and never miss a bit!.</p>
              <form action="" method="post" class="row gy-3">
                <div class="col-lg-8 col-md-8 ">
                  <div class="sub-email">
                    <input type="email" name="sub_email" placeholder="Your Email Address..." required>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="sub-button">
                    <button type="submit" name="sub_email_submit" class="btn btn3 w-100">SUBSCRIBE</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Subscribe Section end-->

  <!--Footer Section start-->
  <footer data-aos="fade-up" class="pt-9 text-center text-white position-relative z-1">
    <div class="overlay z-n1 start-0"></div>
    <div class="container">
      <div class="footer-content w-lg-50 m-auto">
        <div class="footer-logo mb-4 pt-1">
          <a href="index.php"><img src="images/logo/1.png" class="w-50" alt="footer-logo"></a>
        </div>
        <div class="footer-disciption border-bottom border-white border-opacity-25 m-auto mb-6">
          <p class=" mb-6">3rd ASFI Annual Virtual Multidisciplinary Conference and Boot Camp 2025</p>
          <div class="footer-socials pb-6">
            <ul class="m-0 p-0">
              <li class="d-inline me-2">
                <a target="_blank" href="https://www.facebook.com/groups/392075606316714/" class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="d-inline me-2">
                <a target="_blank" href="https://www.instagram.com/asfi_africa/" class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                  <i class="fa fa-instagram"></i>
                </a>
              </li>
              <li class="d-inline me-2">
                <a target="_blank" href="https://twitter.com/AfricanScience2" class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="d-inline me-2">
                <a target="_blank" href="https://www.youtube.com/c/ASFIHubForResearchCapacityBuilding" class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                  <i class="fa fa-youtube-play"></i>
                </a>
              </li>
              <li class="d-inline me-2">
                <a target="_blank" href="https://www.linkedin.com/in/african-science-frontiers-initiatives-asfi-74967b240/" class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                  <i class="fa fa-linkedin"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="footer-menu pb-9">
          <ul class="p-0 m-0">
            <li class="d-inline mx-2"><a href="https://africansciencefrontiers.com/about.php"><small>About</small></a></li>
            <li class="d-inline mx-2"><a href="https://africansciencefrontiers.com/news.php"><small>news</small></a></li>
            <li class="d-inline mx-2"><a href="#event-speakers"><small>Event Speakers</small></a></li>
            <li class="d-inline mx-2"><a href="https://africansciencefrontiers.com/partnership.php"><small>Donations</small></a></li>
            <!-- <li class="d-inline mx-2"><a href="pricing.php"><small>Ticket Pricing</small></a></li> -->
            <li class="d-inline mx-2"><a href="https://africansciencefrontiers.com/contact.php"><small>Contact Us</small></a></li>
          </ul>
        </div>
      </div>
      <div class="copyright pb-6 pt-1">
        <small>Copyright &#169; <?php echo date("Y");?> africansciencefrontiers.com. All Rights Reserved</small>
      </div>
    </div>
  </footer>
  <!--Footer Section end-->

  <!--Back-to-top Button start-->
  <div id="back-to-top">
    <a href="#" class="bg-pink position-relative align-items-center rounded-circle d-block"></a>
  </div>
  <!--Back-to-top Button end-->


  <script src="js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/custom-nav.js"></script>
  <script src="js/plugin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="js/main.js?v=1.0.0"></script>

  <?php
      if(isset($_SESSION['alert']) && $_SESSION['alert'] !=''){
  ?>
    <script>
      Swal.fire({
        title: "<?php echo $_SESSION['alert'] ?>",
        icon: "<?php echo $_SESSION['alert_code'] ?>",
        confirmButtonText: 'OK'
      }).then((result) => {
        window.location = "<?php echo $_SESSION['alert_link'] ?>";
      });
    </script>
  <?php
    unset($_SESSION['alert']);
      }
  ?>

</body>

</html>