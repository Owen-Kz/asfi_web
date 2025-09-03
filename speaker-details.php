<?php include_once('header.php');
if(isset($_GET['id'])){

	$id = $_GET['id'];

	$result = $db->query("SELECT * FROM `events_speakers` WHERE `speaker_id`= '$id'");
	    while($product = $result->fetch_assoc()): 
			 $speaker_names = $product['speaker_names'];
			 $speaker_image = $product['speaker_image'];
			 $speaker_position = $product['speaker_position'];
             $speaker_details = $product['speaker_details'];
			 $speaker_topic = $product['speaker_topic'];
		endwhile; 
    }else{
        header('Location: AsfiWomenWeek2024.php');
        exit();	
    }
?>
<title><?=$speaker_names?> - 2nd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp 2024 || African Science Frontiers Initiatives (ASFI)</title>
  <!-- Page Title -->
  <section class="page-title" style="background-image:url(admin/img/event_speaker/<?=$speaker_image?>)">
        <div class="auto-container">
            <div class="content-box">
                <h1><?=$speaker_names?> <br> 2nd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp 2024 </h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li><?=$speaker_names?> - 2nd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp 2024 </li>
                </ul>
            </div>
        </div>

    </section>
 <!-- Causes Details -->
 <div class="sidebar-page-container cause-details">
    <br><br>
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <div class="sec-title mb-40 row">
                        <div class="col-lg-4">
                            <div class="text-center">
                                <img src="admin/img/event_speaker/<?=$speaker_image?>" width="100%" alt="">
                                <p><b><?=$speaker_names?></b></p>
                                <p><?=$speaker_position?></p>
                                <h4>
                                    <i><span style="color:#d40032;"> <?=$speaker_topic?></span></i>
                                </h4>
                            </div>
                        </div>
                           
                        <div class="col-lg-8">
                            <div class="text">
                    
                                <?=$speaker_details?>
                            </div>


                        </div>
                    </div> 
                </div>                
            </div>
        </div>
    </div>


   


<?php include_once('footer.php'); ?>