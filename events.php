<?php include_once('header.php');?>
<title>Events  || African Science Frontiers Initiatives (ASFI)</title>
<?php $result_events = $db->query("SELECT * FROM events WHERE event_date >= CURRENT_DATE()  ORDER BY event_date ASC LIMIT 1"); 
    while($events = $result_events->fetch_assoc()): 
    $date_event = date_create($events['event_date']);
?>
    <!-- Upcoming Section -->
    <section class="upcoming-events-section-two" style="background-image: url(images/image3.png);">
        <div class="auto-container">
            <div class="sec-title text-center light">
                <h1>Upcoming Events</h1>
            </div>
            <div class="wrapper-box">
                <div class="countdown-timer-two">
                    <div class="default-coundown">
                        <div class="box">
                            <div class="countdown time-countdown-three" data-countdown-time="<?=$events['event_date']?>"></div>
                        </div>
                    </div>
                </div>
                <div class="event-block-five">
                    <h1><?=$events['event_title']?></h1>
                    <div style="color:#fff;" class="text"><?=$events['event_location']?> <br><?php echo date_format($date_event, 'j');?> <?php echo date_format($date_event, 'F');?> <?php echo date_format($date_event, 'Y');?>, 10.00am</div>
                    
                    <div class="link-box">
                            <a href="events-details.php?event_id=<?=$events['event_id']?>" class="theme-btn btn-style-thirteen"><span>See Event Details</span></a>
                        <?php if(!empty($events['event_link'])){?>
                         <?php if($events['event_id'] = 8){?>
                            <a href="virtual_conf_2023_abstract.php" class="theme-btn btn-style-thirteen"><span>Submit Your Abstract</span></a>
                            <br>
                            <a href="event_registration.php" class="theme-btn btn-style-one"><span>Register for event</span></a>
                         <?php }else{ ?>
                            <a href="<?=$events['event_link']?>" class="theme-btn btn-style-thirteen"><span>Register for event</span></a>
                         <?php } ?>
                            
                        <?php } ?>
                    </div>
                </div>
            </div>
                
        </div>
    </section>
<?php endwhile ?>	
    <!-- Events Section -->
    <section class="events-section style-two">
        <div class="auto-container">
            <div class="row">
            <?php $result_events = $db->query("SELECT * FROM events WHERE event_date >= CURRENT_DATE()  ORDER BY event_date ASC LIMIT 6"); 
                while($events = $result_events->fetch_assoc()): 
                $date_event = date_create($events['event_date']);
            ?>
                <div class="event-block-one col-lg-4 col-md-6">
                    <div class="inner-box">
                        <div class="image"><img src="admin/img/events/<?=$events['event_image']?>" alt=""></div>
                        <div class="lower-content">
                        <div class="date">
                            <h1><?php echo date_format($date_event, 'j');?></h1>
                            <div class="text"><span><?php echo date_format($date_event, 'F');?></span> <br><?php echo date_format($date_event, 'Y');?> </div>
                            </div>
                            <h4><a href="events-details.php?event_id=<?=$events['event_id']?>"><?=$events['event_title']?></a></h4>
                            <div class="location"><span class="flaticon-point"></span><?=$events['event_location']?></div>
                        </div>
                        <div class="link-btn"><a href="events-details.php?event_id=<?=$events['event_id']?>"><span class="flaticon-next-1"></span>See Event Details</a></div>
                    </div>
                </div>
            <?php endwhile ?>	 
            </div>
            <div class="posts-pagination">
                <ul>
                    <li><a href="#"><span class="flaticon-arrow-1"></span></a></li>
                    <li><a href="#">01</a></li>
                    <li><a href="#">02</a></li>
                    <li><a href="#"><span class="flaticon-arrow-1"></span></a></li>
                </ul>
            </div>
        </div>
    </section>


<?php include_once('footer.php');?>