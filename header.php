<?php
session_start();
require_once __DIR__ . '/../includes/spam_detector.php';
include ('includes/db_connect.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
<link rel="icon" href="images/icon.png" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Prata|Rubik:300,400,500,700&amp;display=swap" rel="stylesheet">

<!-- Stylesheets -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/swiper.min.css" rel="stylesheet">
<link href="css/flaticon.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link href="css/custom-animate.css" rel="stylesheet">
<link href="css/jquery.fancybox.min.css" rel="stylesheet">
<link href="css/owl.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="css/shop.css" rel="stylesheet">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Equipping Africa’s science that solves Africa’s developmental challenges"/>
<meta name="keywords" content="Equipping, African Scientists, Nigeria, Africa, ASFI, science ">

</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2RCGQKFQKZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2RCGQKFQKZ');
</script>

<body>

<div class="page-wrapper">

    
    <!-- Main Header-->
    <header class="main-header">
        <!-- Top bar -->
        <div class="top-bar theme-bg">
            <div class="auto-container">
                <div class="wrapper-box">
                    <div class="left-content">
                        <div class="text">Equipping Africa’s science that solves Africa’s developmental challenges</div>
                    </div>
                    <div class="right-content">
                       
                        <ul class="login-info">
                        <?php if(!isset($_SESSION['member_id'])){?> 
                            <li><span class="flaticon-login"></span><a href="login.php">Login</a></li>
                            <li><span class="flaticon-user"></span><a href="registration.php">Become A Member</a></li>
                            <?php }else{
						            $member_id = $_SESSION['member_id'];
									$result_1 = $db->query("SELECT * FROM members_registration WHERE member_id=$member_id");
									while($name = $result_1->fetch_assoc()): 
										
                                    $member_firstname = $name['member_firstname'];
                                    $member_surname = $name['member_surname'];
                                    endwhile; 
                            ?>
                            <li><span class="flaticon-login"></span><a href="logout.php">Logout</a></li>
                            <li><span class="flaticon-user"></span><a href="membership_dashboard.php">Hi <?=$member_firstname?> !</a></li>
                            <?php } ?>
                        </ul>
                        <ul class="social-icon-one">
                            <li><a href="https://www.facebook.com/groups/392075606316714/"><span class="fa fa-facebook"></span></a></li>
                            <li><a href="https://twitter.com/AfricanScience2"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="https://www.youtube.com/c/ASFIHubForResearchCapacityBuilding"><span class="fa fa-youtube"></span></a></li>
                             <li><a href="https://www.instagram.com/asfi_africa/"><span class="fa fa-instagram"></span></a></li>
                            <li><a href="https://www.linkedin.com/in/african-science-frontiers-initiatives-asfi-74967b240/"><span class="fa fa-linkedin"></span></a></li>
                        </ul>
                    </div>
                </div>                
            </div>
        </div>

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="auto-container">
                <div class="wrapper-box">
                    <div class="logo-column">
                        <div class="logo-box">
                            <div class="logo"><a href="index.php"><img src="images/logo2.png" width="100px" alt="" title=""></a></div>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="option-wrapper">
                            <div class="nav-outer">
                                
                                <!-- Main Menu -->
                                <nav class="main-menu navbar-expand-xl navbar-dark">
                                    
                                    <div class="collapse navbar-collapse">
                                        <ul class="navigation">
                                            <li class="current" ><a href="index.php">Home</a></li>
                                            <li class="dropdown"><a href="about.php">About ASFI</a>
                                                <ul>
                                                    <li><a href="about.php">Background</a></li>
                                                    <li><a href="about.php">Vision & Mission</a></li>
                                                    <li><a href="excos.php">ASFI Executive Committee </a></li>
                                                    <li><a href="member_General_assembly.php">Member's General Assembly</a></li>
                                                    <li><a href="Junior_and_Senior_Sub_Assembly.php">Junior & Senior Sub-Assembly</a></li>
                                                </ul>
                                            </li>
                                            <li class="dropdown"><a href="about.php">ASFI Activities</a>
                                                <ul>
                                                    <li><a href="courses.php">Courses & Workshops</a></li>
                                                    <li><a href="https://africansciencefrontiers.com/virtual_conf_2025_abstract?event_id=12">2025 Virtual Conference</a></li>
                                                    <li><a href="AsfiWomenWeek2024.php">ASFI Women’s Week 2024</a></li>
                                                    <li><a href="https://africansciencefrontiers.com/events-details.php?event_id=10">2024 Virtual Conference</a></li>
                                                    <li><a href="2023_virtual_conf_event_highlight.php">2023 Virtual Conference</a></li>
                                                    <li><a href="ASFI_In_Number_2020-2022.php">ASFI In Numbers 2020-2022 </a></li>
                                                    <li><a href="ASFI_Impact_essays_2023.php">ASFI Impact Essays 2023 </a></li>
                                                    <li><a href="events-details.php?event_id=7">ASFI Science Seminar Series</a></li>
                                                    <li><a href="events-details.php?event_id=6">Dr. Nwaru’s Research Tips & Tricks</a></li>
                                                    <li><a href="mentoring_program.php">ASFI Mentoring Program </a></li>
                                                    <li><a href="ASFIscholar.php">ASFIScholar</a></li>
                                                    <li><a href="news.php">ASFI News </a></li>
                                                </ul>
                                            </li>
                                 
                                           

                                            
                                            <li><a href="partnership.php">Donation & Payments</a></li>
                                            <li><a href="contact.php">Contact us</a></li>
                                        </ul>
                                    </div>
                                </nav><!-- Main Menu End-->
                            </div>
                            <!--Search Box-->
                            <div class="search-box-outer">
                                <div class="dropdown">
                                    <button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-search"></span></button>
                                    <ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu3">
                                        <li class="panel-outer">
                                            <div class="form-container">
                                                <form method="post" action="">
                                                    <div class="form-group">
                                                        <input type="search" name="field-name" value="" placeholder="Search...." required="">
                                                        <button type="submit" class="search-btn"><span class="fa fa-search"></span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="link-btn">
                            <?php if(!isset($_SESSION['member_id'])){?> 
                                <a href="login.php" class="theme-btn btn-style-one"><span>login / Sign Up</span></a>
                                <?php }else{
						            $member_id = $_SESSION['member_id'];
									$result_1 = $db->query("SELECT * FROM members_registration WHERE member_id=$member_id");
									while($name = $result_1->fetch_assoc()): 
										
                                    $member_firstname = $name['member_firstname'];
                                    $member_surname = $name['member_surname'];
                                    endwhile;  ?>
                                <a href="membership_dashboard.php" class="theme-btn btn-style-one"><span>Hi <?=$member_firstname?>!</span></a>
                                <?php } ?>
                            </div>

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Header Upper-->

        <!--End Header Upper-->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="wrapper-box">
                    <div class="logo-column">
                        <div class="logo-box">
                            <div class="logo"><a href="index.php"><img src="images/logo2.png" alt="" width="170px" title=""></a></div>
                        </div>
                    </div>
                    <div class="menu-column">
                        <div class="nav-outer">
                            
                            <div class="nav-inner">

                                <!-- Main Menu -->
                                <nav class="main-menu navbar-expand-xl navbar-dark">
                                    
                                    <div class="collapse navbar-collapse">
                                        <ul class="navigation">
                                        </ul>
                                    </div>
                                </nav><!-- Main Menu End-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu  -->
        <div class="mobile-menu style-one">
            <div class="menu-box">
                <div class="logo"><a href="index.php"><img src="images/logo2.png" width="170px" alt=""></a></div>
                <!-- Main Menu -->
                <nav class="main-menu navbar-expand-xl navbar-dark">
                    <div class="navbar-header">
                        <!-- Toggle Button -->      
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="flaticon-menu"></span>
                        </button>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navigation">
                            
                        </ul>
                    </div>
                </nav>
                <!-- Main Menu End-->
                <!--Search Box-->
                <div class="search-box-outer">
                    <div class="dropdown">
                        <button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-search"></span></button>
                        <ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu4">
                            <li class="panel-outer">
                                <div class="form-container">
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <input type="search" name="field-name" value="" placeholder="Search...." required="">
                                            <button type="submit" class="search-btn"><span class="fa fa-search"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>     
                
        </div>
        <!-- End Mobile Menu -->

        <div class="nav-overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div>
    </header>
    <!-- End Main Header -->
