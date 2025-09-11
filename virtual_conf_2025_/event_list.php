<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Event Lists-Eventen</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!--CSS Plugins-->
  <link rel="stylesheet" href="css/plugin.css">
  <!-- Default CSS-->
  <link rel="stylesheet" href="css/default.css">
  <!--Custom CSS-->
  <link rel="stylesheet" href="css/styles.css">


  <!--FontAwesome CSS-->
  <link rel="stylesheet" href="icons/font-awesome.min.css">

  
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
                  <a href="#">
                    <i class="fa fa-facebook border-social rounded-circle text-center"></i>
                  </a>               
                </li>
                <li class="d-inline">
                  <a href="#">
                    <i class="fa fa-twitter border-social rounded-circle text-center"></i>
                  </a>
                </li>
                <li class="d-inline">
                  <a href="#">
                    <i class="fa fa-google border-social rounded-circle text-center"></i>
                  </a>
                </li>
                <li class="d-inline">
                  <a href="#">
                    <i class="fa fa-instagram border-social rounded-circle text-center"></i>
                  </a>
                </li>
                <li class="d-inline">
                  <a href="#">
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
                  <small>+33 877 554 332</small></li>
                <li class=" px-2 border-end d-inline border-lightgrey border-opacity-50">
                  <i class="fa fa-envelope-o pe-1"></i>
                  <small>info@website.com</small></li>
                <li class=" px-2 d-inline ">
                  <i class="fa fa-clock-o pe-1"></i>
                  <small>Mon - Fri: 9:00 - 18:30</small></li>
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
              <img src="images/logo/1.png" alt="Logo" class="w-100">
            </div>
          </div>  
          <div class="col-lg-10 col-md-6">
            <div class="collapse navbar-collapse justify-content-between ms-8 " id="bs-example-navbar-collapse-1">
              <ul class="navbar-nav align-items-center" id="responsive-menu">
                <li class="nav-item ">
                  <a class="nav-link px-2 my-4 py-0 text-white" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link px-2 my-4 py-0 text-white" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle px-2 my-4 py-0 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Speaker
                  </a>
                  <ul class="dropdown-menu bg-lightgrey p-0 rounded">
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="speaker_list.php">Speakers List</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="speaker_detail.php">Speakers Details</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle px-2 my-4 py-0 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Schedule
                  </a>
                  <ul class="dropdown-menu bg-lightgrey p-0 rounded">
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="event_list.php">Event List</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="event-detail.php">Event Details</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle px-2 my-4 py-0 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pages
                  </a>
                  <ul class="dropdown-menu bg-lightgrey p-0 rounded">
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="sponsers.php">Sponsors</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="gallery.php">Gallery</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="pricing.php">Pricing</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="faq.php">Faq</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="testimonial.php">Testimonials</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="product-list.php">Product List</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="product-single.php">Product Single</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="error.php">404 Error</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="search-result.php">Search Result</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="coming-soon.php">Coming Soon</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown ">
                  <a class="nav-link dropdown-toggle px-2 my-4 py-0 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    News
                  </a>
                  <ul class="dropdown-menu bg-lightgrey p-0 rounded">
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="news-list.php">News List</a></li>
                    <li><a class="dropdown-item py-3 px-6 text-capitalize black border-0" href="news-single.php">News Single</a></li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link px-2 my-4 py-0 text-white" href="contact.php">Contact</a>
                </li>
              </ul>
                <div class="menu-search">
                  <a href="#search1" class="mt_search">
                    <i class="fa fa-search fa-lg me-5 text-white"></i>
                  </a>
                  <a class="btn btn3" href="book-now.php">Buy Ticket<i class="fa fa-long-arrow-right ms-4"></i></a>
              </div>
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
<section class="banner page-banner position-relative pb-0">
  <div class="overlay">
  </div>
  <div class="container">
    <div class="page-title text-center position-relative py-11">
     <h2 class="text-white">Event Lists</h2>
    </div> 
  </div>
</section>
<!--Banner Section end-->

<!--Schedules Section start-->
<section class="schedules pb-0">
  <div class="container">
    <div class="schedule-inner">
      <div class="schedule-list-outer text-center">
          <div class="row align-items-center">
            <div class="col-lg-3">
              <div class="schedule-day schedule-day1 text-lg-start py-6 position-relative ps-2 z-1">
                  <h4 class="pink mb-2">1ST DAY</h4>
                  <h6 class="mb-2">APRIL 23, 2024</h6>
                  <P>William Mathew Theater<br>
                    2390 NW 2nd Ave, Miami, FL 33127</P>
              </div>        
            </div>
            <div class="col-lg-9">
              <div class="schedule-list  text-center text-sm-start m-sm-0">
                <div class="row gx-md-5">
                  <div class="col-lg-6 col-md-6">
                    <div class="schedule-list-left">
                      <div class=" schedule-list-box bg-lightgrey   border border-white border-2 rounded px-6 py-4 mb-4">
                        <div class="schedule-box-title">
                          <h5 class="mb-2"><a href="event-detail.php" class="black">REGISTRATION & BREAKFAST</a></h5>
                        </div> 
                        <div class="schedule-box-info">
                            <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
                            <ul class="mb-2 p-0">
                              <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
                              <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
                            </ul>
                          </div>
                          <div class="schedule-box-bio d-md-flex">
                            <div class="schedule-bio-image ">
                              <img src="images/team/2.jpg" alt="team-image" class="me-2 rounded-circle">
                            </div> 
                            <div class="schedule-bio-info"> 
                              <p class="mt-1 mb-0"><a href="speaker_detail.php" class="pink">JESUS HOLLAND</a></p>
                              <small>Host & Speaker</small>
                            </div>  
                          </div>  
                      </div>
                      <div class=" schedule-list-box bg-white border-lightgrey border border-2 rounded px-6 py-4 mb-4">
                        <div class="schedule-box-title">
                          <h5 class="mb-2"><a href="event-detail.php" class="black">Business Management Info</a></h5>
                        </div> 
                        <div class="schedule-box-info">
                          <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
                          <ul class="mb-2 p-0">
                            <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
                            <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
                          </ul>
                        </div>
                        <div class="schedule-box-bio d-md-flex">
                          <div class="schedule-bio-image">
                            <img src="images/team/3.jpg" alt="team-image" class="me-2 rounded-circle">
                          </div> 
                          <div class="schedule-bio-info"> 
                            <p class="mt-1 mb-0 pink"><a href="speaker_detail.php" class="pink">NELSON KETY</a></p>
                            <small>Host & Speaker</small>
                        </div>
                      </div>    
                    </div>
                   </div>
                 </div>   
                 <div class="col-lg-6 col-md-6">
                    <div class="schedule-list-left">
                      <div class=" schedule-list-box bg-white border-lightgrey border border-2 rounded px-6 py-4 mb-4">
                        <div class="schedule-box-title">
                          <h5 class="mb-2"><a href="event-detail.php" class="black">Workshop: Culture & Creativity</a></h5>
                        </div> 
                        <div class="schedule-box-info">
                          <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
                          <ul class="mb-2 p-0">
                            <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
                            <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
                          </ul>
                        </div>
                        <div class="schedule-box-bio d-md-flex">
                          <div class="schedule-bio-image">
                            <img src="images/team/1.jpg" alt="team-image" class="me-2 rounded-circle">
                          </div> 
                          <div class="schedule-bio-info"> 
                            <p class="mt-1 mb-0 pink"><a href="speaker_detail.php" class="pink">NELSON KETY</a></p>
                            <small>Host & Speaker</small>
                          </div>
                        </div>    
                      </div>
                      <div class=" schedule-list-box bg-lightgrey   border border-white border-2 rounded px-6 py-4">
                        <div class="schedule-box-title">
                          <h5 class="mb-2"><a href="event-detail.php" class="black">Exploration & Approch</a></h5>
                        </div> 
                        <div class="schedule-box-info">
                            <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
                            <ul class="mb-2 p-0">
                              <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
                              <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
                            </ul>
                        </div>
                          <div class="schedule-box-bio d-md-flex">
                            <div class="schedule-bio-image ">
                              <img src="images/team/2.jpg" alt="team-image" class="me-2 rounded-circle">
                            </div> 
                            <div class="schedule-bio-info"> 
                              <p class="mt-1 mb-0 pink"> <a href="speaker_detail.php" class="pink">JESUS HOLLAND</a></p>
                              <small>Host & Speaker</small>
                            </div>  
                        </div>  
                      </div>
                    </div>
                  </div> 
                </div>    
              </div>  
            </div>
          </div> 
      </div>
    </div>  
  </div> 
</section>

<section class="schedule-2 schedules">
  <div class="container">
    <div class="schedule-2-inner w-lg-60 m-auto text-center text-md-start">
      <div class="schedule-2-day pb-4 d-md-flex align-items-center">
        <div class="schedule-icon">
          <i class="fa fa-calendar text-grey opacity-25" aria-hidden="true"></i>
        </div>
        <div class="schedule-date px-4">
          <h4 class="pink">2nd DAY</h4>
          <h6 class="">APRIL 24, 2024</h6>
        </div>
        <div class="event-location">
         <P class="m-0">William Mathew Theater<br>
          2390 NW 2nd Ave, Miami, FL 33127</P>
        </div>  
      </div> 
      <div class="schedule-list">
        <div class=" schedule-list-box bg-white border-lightgrey border border-2 rounded px-6 py-4 mb-4">
          <div class="schedule-box-title">
            <h5 class="mb-2"><a href="event-detail.php" class="black">SPEED: MARKETING MASTER!</a></h5>
          </div> 
          <div class="schedule-box-info">
            <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
            <ul class="mb-2 p-0">
              <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
              <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
            </ul>
          </div>
          <div class="schedule-box-bio d-md-flex ">
            <div class="schedule-bio-image">
              <img src="images/team/2.jpg" alt="team-image" class="me-2 rounded-circle">
            </div> 
            <div class="schedule-bio-info"> 
              <p class="mt-1 mb-0 pink"><a href="speaker_detail.php" class="pink">NELSON KETY</a></p>
              <small>Host & Speaker</small>
            </div>
          </div>    
        </div>
        <div class=" schedule-list-box bg-lightgrey   border border-white border-2 rounded px-6 py-4 mb-4">
          <div class="schedule-box-title">
            <h5 class="mb-2"><a href="event-detail.php" class="black">Digital Marketing Theory</a></h5>
          </div> 
          <div class="schedule-box-info">
              <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
              <ul class="mb-2 p-0">
                <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
                <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
              </ul>
          </div>
            <div class="schedule-box-bio d-md-flex">
              <div class="schedule-bio-image ">
                <img src="images/team/3.jpg" alt="team-image" class="me-2 rounded-circle">
              </div> 
              <div class="schedule-bio-info"> 
                <p class="mt-1 mb-0 pink"><a href="speaker_detail.php" class="pink">JESUS HOLLAND</a></p>
                <small>Host & Speaker</small>
              </div>  
          </div>  
        </div>
        <div class=" schedule-list-box bg-white border-lightgrey border border-2 rounded px-6 py-4 ">
          <div class="schedule-box-title">
            <h5 class="mb-2"><a href="event-detail.php" class="black">Global Inovations in Medias</a></h5>
          </div> 
          <div class="schedule-box-info">
            <p class="mb-2"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo, luctus nec ullamcorper mattis, pulvinar dapibus leo.</small></p>
            <ul class="mb-2 p-0">
              <li class="d-inline"><i class="fa fa-clock-o pink me-2" aria-hidden="true"></i><small>08:30 - 09:30 AM</small></li>
              <li class="d-inline"><i class="fa fa-thumb-tack pink mx-2" aria-hidden="true" ></i><small>Exploration Hall</small></li>
            </ul>
          </div>
          <div class="schedule-box-bio d-md-flex">
            <div class="schedule-bio-image">
              <img src="images/team/1.jpg" alt="team-image" class="me-2 rounded-circle">
            </div> 
            <div class="schedule-bio-info"> 
              <p class="mt-1 mb-0 pink"><a href="speaker_detail.php" class="pink">NELSON KETY</a></p>
              <small>Host & Speaker</small>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </div>
</section>
<!--Schedules Section end-->

<!--Subscribe Section start-->
<section class="subscribe py-4">
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
            <p class="text-white mb-4 text-center text-lg-start"> Excepteur sint occaecat cupidatat non proident, sunt
              in culpa qui officia deserunt mollit anim id est laborum.</p>
            <div class="row gy-3">
              <div class="col-lg-8 col-md-8 ">
                <div class="sub-email">
                  <input type="email" placeholder="Email" required>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="sub-button">
                  <button class="btn btn3 w-100">SUBSCRIBE</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Subscribe Section end-->

<!--Footer Section start-->
<footer class="pt-9 text-center text-white position-relative z-1">
  <div class="overlay z-n1 start-0"></div>
  <div class="container">
    <div class="footer-content w-lg-50 m-auto">
      <div class="footer-logo mb-4 pt-1">
        <a href="index.php"><img src="images/logo/1.png" class="w-50" alt="footer-logo"></a>
      </div>
      <div class="footer-disciption border-bottom border-white border-opacity-25 m-auto mb-6">
        <p class=" mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
          labore.</p>
        <div class="footer-socials pb-6">
          <ul class="m-0 p-0">
            <li class="d-inline me-2">
              <a class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                <i class="fa fa-facebook"></i>
              </a>
            </li>
            <li class="d-inline me-2">
              <a class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                <i class="fa fa-twitter"></i>
              </a>
            </li>
            <li class="d-inline me-2">
              <a class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                <i class="fa fa-youtube-play"></i>
              </a>
            </li>
            <li class="d-inline me-2">
              <a class="d-inline-block rounded-circle bg-white  bg-opacity-25">
                <i class="fa fa-linkedin"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-menu pb-9">
        <ul class="p-0 m-0">
          <li class="d-inline mx-2"><a href="about.php"><small>About Event</small></a></li>
          <li class="d-inline mx-2"><a href=""><small>Services</small></a></li>
          <li class="d-inline mx-2"><a href="speaker_list.php"><small>Speakers</small></a></li>
          <li class="d-inline mx-2"><a href="event_list.php"><small>Schedule</small></a></li>
          <li class="d-inline mx-2"><a href="pricing.php"><small>Ticket Pricing</small></a></li>
          <li class="d-inline mx-2"><a href="contact.php"><small>Contact Us</small></a></li>
        </ul>
      </div>
    </div>
    <div class="copyright pb-6 pt-1">
      <small>Copyright &#169;2024 Eventen. All Rights Reserved Copyright</small>
    </div>
  </div>
</footer>
<!--Footer Section end-->    

<!--Bacl-to-top Button start-->
<div id="back-to-top">
  <a href="#" class="bg-pink position-relative align-items-center rounded-circle d-block"></a>
</div>
<!--Bacl-to-top Button end-->


    <script src="js/jquery-3.7.1.min.js"></script>  
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom-nav.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/main.js"></script>
</body>
</html>