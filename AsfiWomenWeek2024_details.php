<?php include_once('header.php');
if(isset($_GET['id'])){

	$id = $_GET['id'];

	$result = $db->query("SELECT * FROM `womenweek2024` WHERE `id`= '$id'");
	    while($product = $result->fetch_assoc()): 
			 $names = $product['names'];
			 $image = $product['image'];
			 $details = $product['details'];
		endwhile; 
    }else{
        header('Location: AsfiWomenWeek2024.php');
        exit();	
    }
?>
<title><?=$names?> - ASFI Women's Week 2024 || African Science Frontiers Initiatives (ASFI)</title>
  <!-- Page Title -->
  <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1><?=$names?> -  ASFI Women's Week 2024 </h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li><?=$names?> - ASFI Women's Week 2024 </li>
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
                        <div class="col-lg-3">
                            <div class="text-center">
                                <img src="images/womenweek2024/<?=$image?>" width="100%" alt="">
                            </div>
                        </div>
                           
                        <div class="col-lg-9">
                            <div class="text">
                                <p><b><?=$names?></b></p>
                                <?=$details?>
                            </div>
                           
                        </div>
                    </div> 
                </div>                
            </div>
        </div>
    </div>


   


<?php include_once('footer.php'); ?>