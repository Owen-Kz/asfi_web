<?php include_once('header.php');

if(isset($_GET['event_id'])){
	$event_id = $_GET['event_id'];

	$result = $db->query("SELECT * FROM `events` WHERE `event_id`= '$event_id'");
	    while($product = $result->fetch_assoc()): 
			 $event_title = $product['event_title'];
			 $event_date = $product['event_date'];
			 $event_time = $product['event_time'];
			 $event_location = $product['event_location'];
			 $event_link = $product['event_link'];
			 $event_details = $product['event_details'];
			 $event_status = $product['event_status'];
             $event_image = $product['event_image'];
		endwhile; 
        $event_date1 = date_create($event_date);
		
  }
?>
<title><?=$event_title?> || African Science Frontiers Initiatives (ASFI)</title>

    <!-- Upcoming Section -->
    <section class="upcoming-events-section-two style-two" style="background-image: url(images/image3.png);">
        <div class="auto-container">
            <div class="sec-title text-center light">
                <h1><?=$event_title?> </h1>
            </div>
            <?php if($event_id != 6 && $event_id != 7){ ?>
            <div class="wrapper-box">
                <div class="countdown-timer-two">
                    <div class="default-coundown">
                        <div class="box">
                            <div class="countdown time-countdown-three" data-countdown-time="<?=$event_date?>"></div>
                        </div>
                    </div>
                </div>
            </div> 
            <?php } ?>
        </div>
    </section>
<?php if($event_id != 6 && $event_id != 7 && $event_id != 10){ ?>
    <!-- Event Time & Place -->
    <div class="event-time-place">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="content">
                        <h2>Where</h2>
                        <div class="text"><?=$event_location?></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content">
                        <h2>When</h2>
                        <div class="text"> Block your calendar on - <?php echo date_format($event_date1, 'j');?> <?php echo date_format($event_date1, 'F');?>, <?php echo date_format($event_date1, 'Y');?><br><?=$event_time?> </div>
                    </div>
                </div>
            </div>
        </div>            
    </div>
    <?php } ?>
    <br>
 <?php if($event_id == 10){?>
 <!-- Events Section -->
    <section class="events-section style-two">
        <div class="auto-container"><!--
             <div class="row">
                <div class="col-lg-4 col-md-4"></div>
                <div class="event-block-one col-lg-4 col-md-4"><a href="virtual_conf_2023_intro.php">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/welcome-image.jpg" alt=""></div>
                        <div class="lower-content">
                            <div class="location">Welcome & Intro For ASFI 2023 Virtual Conference and Boot Camp </div>
                        </div>
                    </div></a>
                </div>
            </div> -->
            <div class="row">
                
                <div class="event-block-one col-lg-4 col-md-6"><a href="event_registration.php?event=<?=$event_id?>">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/asfi-image1.png" alt=""></div>
                        <div class="lower-content">
                            <div class="location"><b>Registration for the ASFI 2024 Digital Conference and Boot Camp is now open. Don't miss out on the early bird fee</b></div>
                        </div>
                    </div></a>
                </div>
                
                <div class="event-block-one col-lg-4 col-md-6"><a href="virtual_conf_2024_program.php">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/asfi-image2.png" alt=""></div>
                        <div class="lower-content">
                            <div class="location"><b>View the full programme for the ASFI 2024 Digital Conference and Boot Camp, and explore the programme highlights</b></div>
                        </div>
                    </div></a>
                </div>
                <div class="event-block-one col-lg-4 col-md-6"><a href="virtual_conf_2024_speakers.php">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/asfi-image3.png" alt=""></div>
                        <div class="lower-content">
                            <div class="location"><b>View the profiles of the keynote speakers at the ASFI 2024 Digital Conference and Boot Camp </b></div>
                        </div>
                    </div></a>
                </div>
                <div class="event-block-one col-lg-4 col-md-6"><a href="virtual_conf_2024_abstract.php">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/asfi-image4.png" alt=""></div>
                        <div class="lower-content">
                            <div class="location"><b>Information about abstract for the ASFI 2024 Digital Conference and Boot Camp</b></div>
                        </div>
                    </div></a>
                </div> <!--
                <div class="event-block-one col-lg-4 col-md-6"><a href="virtual_conf_2023_sub_theme_review.php">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/asfi-image5.png" alt=""></div>
                        <div class="lower-content">
                            <div class="location"><b>Review the sub-themes for the ASFI 2023 Digital Conference and Boot Camp</b></div>
                        </div>
                    </div></a>
                </div>
                <div class="event-block-one col-lg-4 col-md-6"><a href="virtual_conf_2023_boot_camp.php">
                    <div class="inner-box">
                        <div class="image"><img src="images/virtual-images/asfi-image6.png" alt=""></div>
                        <div class="lower-content">
                            <div class="location"><b>Boot camp key highlights for the ASFI 2023 Digital Conference and Boot Camp</b></div>
                        </div>
                    </div></a>
                </div>
               -->
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- About Events -->
    <section class="about-event">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-4">
                    <img src="admin/img/events/<?=$event_image?>" alt="">
                </div>
                <div class="col-md-8">
                    <div class="sec-title">
                        <h1 class="text-center"><?=$event_title?></h1>
                        <div class="text"><?=$event_details?></div>
                    </div>
                    <?php if($event_id != 6 && $event_id != 7){ ?>
                    <?php if(!empty($event_link)){?>
                         <?php if($event_id == 12){?>
                            
                            <div class="link-btn text-center"><a href="virtual_conf_2025_abstract?event=12" class="theme-btn btn-style-one"><span>Submit Your Abstract</span></a>  <a href="event_registration.php?event=<?=$event_id?>" class="theme-btn btn-style-one"><span>Event Registration</span></a>  </div>
                         <?php }else{ ?>
                            <div class="link-btn text-center"><a href="<?=$event_link?>" class="theme-btn btn-style-one"><span>Event Registration Link</span></a></div>
                         <?php } ?>
                     <?php } ?>
                     <?php } ?>
                </div>

            </div>
        </div>
    </section>

   

   

<?php include_once('footer.php');?>