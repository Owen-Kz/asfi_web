   <?php
   include (__DIR__.'../../includes/load_env.php');
$siteKey = $_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY');
$captchaSecret = $_ENV['RECAPTCHA_SECRET_KEY'] ?? getenv('RECAPTCHA_SECRET_KEY');
$recaptcha_site_key = $siteKey;
$recaptcha_secret_key = $captchaSecret;
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
   


<div class="newsletter-two">
    <div class="auto-container">
        <div class="wrapper-box">
            <div class="row m-0 justify-content-between align-items-center">
                <div class="column">
                    <div class="logo"><a href="index.php"><img src="images/logo-8.png" alt=""></a></div>
                </div>
                <div class="column">
                    <form action="" method="post">
                        <input type="email" name="sub_email" placeholder="Your Email Address...">
                        <!-- Add reCAPTCHA widget -->
                        <!-- <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div> -->
                        <button type="submit" name="sub_email_submit" class="theme-btn btn-style-fourteen"><span>Subscribe Us</span></button>                        
                    </form>
                </div>
                <div class="column">
                    <ul class="social-icon-three">
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
</div>

<!-- Add reCAPTCHA API script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- Rest of your footer code remains the same -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="auto-container">
            <div class="widget-wrapper">
                <div class="row">
                    <!-- Post Widget -->
                    <div class="col-lg-4 col-md-6 about-widget-five footer-widget">
                        <h4 class="widget-title">About Us</h4>
                        <div class="text">Our continent, Africa, lags behind in most, if not all, indicators of modern societal development. Current trajectories barely give any indication for future hope. Hunger thrives, security worsens, quality of education remains poor, electricity continues to depilated level in most countries, clean water continues to elude us, just to name a few.</div>
                        <h4 class="widget-title">Contact Us</h4>
                        <ul>
                            <li><strong>Phone:</strong> <a href="tel: +2347014363223"> +234(0)-701-436-3223</a></li>
                            <li><strong>Email:</strong> <a href="mailto:info@africansciencefrontiers.com"> info@africansciencefrontiers.com</a></li>
                        </ul>
                    </div>
                    <!-- Link Widget -->
                    <div  class="col-lg-4 col-md-6 link-widget-three  footer-widget">
                        <h4 class="widget-title">Useful Links</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li><a href="index.php">Home </a></li>
                                    <li><a href="about.php">About ASFI</a></li>
                                    <li><a href="events.php">Upcoming Events</a></li>
                                    <li><a href="excos.php">ASFI Executive</a></li>
                                    <li><a href="courses.php">Courses and workshops</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li><a href="events-details.php?event_id=7">ASFI Science Seminar Series</a></li>
                                    <li><a href="events-details.php?event_id=6">Dr. Nwaru’s Research Tips & Tricks</a></li>
                                    <li><a href="mentoring_program.php">ASFI Mentoring Program</a></li>
                                    <li><a href="ASFIscholar.php">ASFIScholar</a></li>
                                    <li><a href="asfi_ambassador_program.php">ASFI Ambassadors Program</a></li>
                                    <li><a href="contact.php">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>                                
                    </div>
                    
                    <!-- Event Widget -->
                    <div class="col-lg-4 col-md-6 event-widget footer-widget">
                        <h4 class="widget-title">Upcoming Events</h4>
                        <?php $result_events = $db->query("SELECT * FROM events WHERE event_date >= CURRENT_DATE()  ORDER BY event_date DESC LIMIT 3"); 
                                 while($events = $result_events->fetch_assoc()): 
                                    $date_event = date_create($events['event_date']);
                        ?>
                        <div class="signle-event">
                            <div class="date"><?php echo date_format($date_event, 'j');?> <br><?php echo date_format($date_event, 'F');?></div>
                            <h5><a href="events-details.php?event_id=<?=$events['event_id']?>"><?=$events['event_title']?></a></h5>
                            <div class="location"><span class="flaticon-point"></span><?=$events['event_location']?></div>
                        </div>
                        <?php endwhile ?> 
                    </div>
                </div>
            </div>                
        </div>
        <div class="footer-bottom-two">
            <div class="auto-container">
                <div class="row m-0 justify-content-between">
                    <div class="copy-right-text"><a style="color:#fff;" href="#">Weperch Technologies LLC.</a></div>
                   
                </div>                
            </div>
        </div>
        <!--Scroll to top-->
        <div class="scroll-to-top scroll-to-target style-one" data-target="html"><span class="icon flaticon-next"></span></div>
    </footer>
  
</div>
<!--End pagewrapper-->



<!-- JS -->
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/TweenMax.min.js"></script>
<script src="js/wow.js"></script>
<script src="js/owl.js"></script>
<script src="js/appear.js"></script>
<script src="js/swiper.min.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/menu-nav-btn.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<!-- Custom JS -->
<script src="js/script.js"></script>
<script src="admin/js/sweetalert.min.js"></script>
<?php
      if(isset($_SESSION['alert']) && $_SESSION['alert'] !=''){
  ?>
    <script>
      swal({
        title: "<?php echo $_SESSION['alert']?>",
        icon: "<?php echo $_SESSION['alert_code']?>",
      }).then(function() {
			window.location = "<?php echo $_SESSION['alert_link']?>";
		});
    </script>
  <?php
    unset($_SESSION['alert']);
      }
  ?>

</body>

<!-- Goodsoul_html/  20 Nov 2019 03:26:36 GMT -->
</html>