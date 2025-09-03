<?php include_once('header.php');?>
<title>ASFI ambassadors’ officers 2022-2023  || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>ASFI ambassadors 2022-2023 </h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>ASFI ambassadors’ officers 2022-2023 </li>
                </ul>
            </div>
        </div>
    </section>
  <!-- Team Section Three -->
  <section class="team-section-three">
        
        <div class="auto-container">
                <div class="row">
                <?php $result_events = $db->query("SELECT * FROM asfi_ambassador  ORDER BY asfi_ambassador_id ASC "); 
                    while($events = $result_events->fetch_assoc()): 
                ?>
                    <!-- Team Blokc One -->
                    <div class="col-lg-3 team-block-one">
                        <div class="inner-box wow fadeInDown" data-wow-delay="200ms">
                            <div class="image"><a href="#"><img src="admin/img/ambassador/<?=$events['asfi_ambassador_image']?>" alt=""></a></div>
                            <div class="lower-content">
                                <h4> <a href="#"><?=$events['asfi_ambassador_names']?>  (<?=$events['asfi_ambassador_country']?> ) </a></h4>
                                <div class="designation"><?=$events['asfi_ambassador_position']?> </div>
                            </div>
                           
                        </div>
                    </div>
                <?php endwhile ?>
                </div> 
        </div>
    </section>
<?php include_once('footer.php');?>