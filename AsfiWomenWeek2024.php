<?php include_once('header.php');?>
<title>ASFI Women's Week 2024  || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>ASFI Women's Week 2024 </h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>ASFI Women's Week 2024 </li>
                </ul>
            </div>
        </div>
    </section>
  <!-- Team Section Three -->
  <section class="team-section-three">
        
        <div class="auto-container">
                <div class="row">
                <?php $result_events = $db->query("SELECT * FROM womenweek2024 "); 
                    while($events = $result_events->fetch_assoc()): 
                ?>
                    <!-- Team Blokc One -->
                    <div class="col-lg-3 team-block-one">
                        <div class="inner-box wow fadeInDown" data-wow-delay="200ms">
                            <div class="image"><a href="AsfiWomenWeek2024_details.php?id=<?=$events['id']?>"><img src="images/womenweek2024/<?=$events['image']?>" alt=""></a></div>
                            <div class="lower-content">
                                <h4> <a href="AsfiWomenWeek2024_details.php?id=<?=$events['id']?>"><?=$events['names']?> </a></h4>
                               
                            </div>
                           
                        </div>
                    </div>
                <?php endwhile ?>
                </div> 
        </div>
    </section>
<?php include_once('footer.php');?>