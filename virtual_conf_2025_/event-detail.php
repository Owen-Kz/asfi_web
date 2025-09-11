<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Event Detail-Eventen</title>

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
     <h2 class="text-white">Event Detail</h2>
    </div> 
  </div>
</section>
<!--Banner Section end-->

<!--Event Detail Section start-->
<section class="event-detail pb-9">
  <div class="container">
    <div class="event-detail-inner">
      <div class="row gx-md-5">
        <div class="col-lg-8">
          <div class="event-detail-left">
            <div class="event-img mb-4">
              <img src="images/group/4.jpg" alt="event-image" class="w-100 rounded">
            </div>
            <div class="event-description pb-4">
              <h4 class="mb-4">Event Description</h4>
              <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              <div class="description-list pb-4">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <ul class="p-0 m-0 list-unstyled">
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Luctus nam per dis lacus</li>
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Penatibus hac quis torquent molestie</li>
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Velit rhoncus dolor adipiscing</li>
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Aenean per Penatibus</li>
                    </ul>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <ul class="p-0 m-0 list-unstyled">
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Luctus nam per dis lacus</li>
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Penatibus hac quis torquent molestie</li>
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Velit rhoncus dolor adipiscing</li>
                      <li class="pb-2 mb-1"><i class="fa fa-long-arrow-right pink pe-1"></i>Aenean per Penatibus</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="qoutation p-4 bg-lightgrey rounded d-md-flex mb-4 text-center text-md-start">
                  <i class="fa fa-quote-left fa-2x text-white bg-pink p-5 rounded" aria-hidden="true"></i>
                  <p class="ms-4 mb-0"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.Lorem ipsum dolor sit amet consectetur adipiscing elit dolor. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.Lorem ipsum dolor.</small></p>
              </div>
            </div>
            <div class="event-speaker mb-5">
              <h4 class="mb-4">Event Speakers</h4>
              <div class="event-speaker-inner text-center text-white">
                <div class="row gy-3">
                  <div class="col-lg-4 col-md-4">
                    <div class="speaker-box  position-relative overflow-hidden text-white">
                      <img class="speaker-image rounded w-100" src="images/speakers/1.jpg" alt="speaker-image">
                      <div class="box-content position-absolute bottom-0 z-1">
                        <h6 class="speaker-title d-block text-white pb-1"><a href="speaker_detail.php">GERARDO AMBROSE</a>
                        </h6>
                        <span class="speaker-post d-block pb-2">Marketing Expert</span>
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
                  <div class="col-lg-4 col-md-4">
                    <div class="speaker-box position-relative overflow-hidden">
                      <img class="speaker-image rounded w-100" src="images/speakers/2.jpg" alt="speaker-image">
                      <div class="box-content position-absolute bottom-0 z-1">
                        <h6 class="speaker-title d-block text-white pb-1"><a href="speaker_detail.php">GERARDO AMBROSE</a>
                        </h6>
                        <span class="speaker-post d-block pb-2">Marketing Expert</span>
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
                  <div class="col-lg-4 col-md-4">
                    <div class="speaker-box position-relative overflow-hidden">
                      <img class="speaker-image rounded w-100" src="images/speakers/4.jpg" alt="speaker-image">
                      <div class="box-content position-absolute bottom-0 z-1">
                        <h6 class="speaker-title d-block text-white pb-1"><a href="speaker_detail.php">GERARDO AMBROSE</a>
                        </h6>
                        <span class="speaker-post d-block pb-2">Marketing Expert</span>
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
        </div>
        <div class="col-lg-4">
          <div class="event-detail-right text-center">
            <div class="event-ticket-price d-md-flex align-items-center justify-content-center justify-content-lg-start mb-5">
              <a class="btn me-4 m-sm-0" href="book-now.php">Buy Ticket</a>
              <h6 class="pink py-2">$50.50</h6>
            </div>
            <div class="organizers-box p-6 box-shadow rounded mb-6">
              <div class="organizer-header mb-5">
                <h6 class="pb-2">About Organizers</h6>
                <div class="sperator w-20 m-auto border-bottom border-2 border-pink"></div>
              </div>
              <div class="organizer-list">
                <div class="organizer d-md-flex text-md-start pb-4 mb-4 border-dashed-bottom-2">
                  <div class="organizer-bio-image ">
                    <a href="speaker_detail.php"><img src="images/team/1.jpg" alt="team-image" class="me-2 rounded-circle m-sm-0"></a>
                  </div> 
                  <div class="organizer-bio-info"> 
                    <p class="mt-1 mb-0 fw-semibold black text-uppercase"><a href="speaker_detail.php" class="black">Rickey Malone</a></p>
                    <small>Speaker</small>
                  </div> 
                </div>
                <div class="organizer d-md-flex text-md-start border-0 pb-1">
                  <div class="organizer-bio-image ">
                    <a href="speaker_detail.php"><img src="images/team/2.jpg" alt="team-image" class="me-2 rounded-circle m-sm-0"></a>
                  </div> 
                  <div class="organizer-bio-info"> 
                    <p class="mt-1 mb-0 fw-semibold black text-uppercase"><a href="speaker_detail.php" class="black">JESUS HOLLAND</a></p> 
                    <small>Host & Speaker</small>
                  </div> 
                </div>
              </div>  
            </div>
            <div class="event-info-box p-6 box-shadow rounded mb-6">
              <div class="info-header mb-5">
                <h6 class="pb-2">Event Info</h6>
                <div class="sperator w-20 m-auto border-bottom border-2 border-pink"></div>
              </div>
              <div class="event-info-list">
                <div class="event-info d-md-flex text-md-start align-items-center pb-3 mb-3 border-dashed-bottom-2">
                  <div class="info-icon">
                    <i class="fa fa-calendar pink me-2 m-sm-0" aria-hidden="true"></i>
                  </div>
                  <div class="event-info-detail ms-1 m-sm-0">
                    <p class="my-1 fw-semibold black text-uppercase">Date</p>
                    <p class="mb-0">27 September 2024</p>
                  </div>
                </div>
                <div class="event-info d-md-flex text-md-start align-items-center pb-3 mb-3 border-dashed-bottom-2">
                  <div class="info-icon">
                    <i class="fa fa-clock-o pink me-2 m-sm-0" aria-hidden="true"></i>
                  </div>
                  <div class="event-info-detail ms-1 m-sm-0">
                    <p class="my-1 fw-semibold black text-uppercase">Time</p>
                    <p class="mb-0">9:00AM - 17:00PM</p>
                  </div>
                </div>
                <div class="event-info d-md-flex text-md-start align-items-center mb-3 border-0">
                  <div class="info-icon">
                    <i class="fa fa-map-o pink me-2 m-sm-0" aria-hidden="true"></i>
                  </div>
                  <div class="event-info-detail ms-1 m-sm-0">
                    <p class="my-1 fw-semibold black text-uppercase">Venue</p>
                    <p class="mb-0">Jakarta Garden City Hall, Room</p>
                  </div>
                </div>
              </div>
              <div class="map">
                <iframe height="200" class="rounded w-100" src="https://maps.google.com/maps?width=100%25&amp;hl=en&amp;q=+(mangal%20bazar)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
              </div>
            </div> 
            <div class="contact-us-outer position-relative rounded">
              <div class="overlay"></div>
              <div class="contact-us  px-6 py-8 position-relative text-white">
                <h4 class="mb-4 text-white">Need Help?</h4>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <div class="contact-btn">
                  <a class="btn btn3" href="contact.php">Contact Us<i class="fa fa-long-arrow-right ms-4"></i></a>
                </div>
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--Event Detail Section end-->


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