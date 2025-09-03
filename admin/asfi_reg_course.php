<?php 
  include_once ('header.php');
 include_once ('side_content.php');
 $count = 0;
 if(isset($_GET['course_id'])){
	$course_id = $_GET['course_id'];
    $result = $db->query("SELECT * FROM `courses` WHERE `course_id`= '$course_id'");
    while($product = $result->fetch_assoc()): 
         $course_title = $product['course_title'];
         $course_duration = $product['course_duration'];
         $course_target = $product['course_target'];
         $course_image = $product['course_image'];
         $course_details = $product['course_details'];
         $course_video_link = $product['course_video_link'];
         $course_status = $product['course_status'];
    endwhile; 



 }else{
    echo "<script>
    window.location.href='course.php';		   
    </script>";
 }
 
  if(isset($_GET['Cleardb'])){
      
        $result_clear = $db->query("DELETE FROM `course_registration` WHERE `course_registration`.`course_reg_course_id` = '$course_id'");
          if($result_clear){
            echo "<script>
            alert('Database deleted successfully');
            window.location.href='asfi_reg_course.php?course_id=$course_id';		   
            </script>";
          }else{
            echo "<script>
            alert('Not Working. Please Try again');
            window.location.href='asfi_reg_course.php?course_id=$course_id';		   
            </script>";
          }
              
  }
 
?>




    <!--main content start-->
    <section id="main-content">
	 <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Registered Applicants</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
               <li><i class="fa fa-square-o"></i><a href="course.php">Courses</a></li>
              <li><i class="fa fa-users"></i>Registered Applicants</li>
            </ol>
          </div>
        </div>
            <?php 
                            $limit = 20;
							  $page = isset($_GET['page']) ? $_GET['page'] : 1;
                              $start = ($page - 1) * $limit;
                              $end = $start + $limit;
                              $result_row = $db->query("SELECT * FROM course_registration WHERE course_reg_course_id = $course_id  LIMIT $start, $limit");
                              $resultCount = $db->query("SELECT * FROM course_registration WHERE course_reg_course_id = $course_id ");
                              $countAll = $resultCount->num_rows;
                              $pages = ceil( $countAll / $limit );
                    
                              $next = $page + 1;
                              $previous = $page - 1;
                              $adjacents = "2"; 
                              $second_last = $pages - 1; // total page minus 1
				
		     ?>	
         	<div class="box-header with-border">
              <div class="row">
                  <div class="col-md-12">
                      <div class="pull-right">
                        <a class="btn btn-success" href="export2.php?course_id=<?=$course_id?>"><i class="icon_plus_alt2"></i> Export To Xcel</a>                                          
                      </div>
                  </div>
              </div>
          </div><!-- /.box-header -->
        <!-- page start-->
         <div class="row">
          <div class="col-lg-12">
                
            <section class="panel">
              <header class="panel-heading">
              <?=$resultCount->num_rows;?> Registered Student For <b><?=$course_title?></b> 
              </header>

              <table class="table table-striped table-advance table-hover">
                
				<tbody>
                  <tr>

                    <th> S/N</th> 
                    <th><i class="icon_profile"></i> First Name</th>
                    <th><i class="icon_profile"></i> Surname</th>
                    <th><i class="icon_mail"></i> Email</th>
                    <th><i class="fa fa-user"></i> Gender</th>
                    <th><i class="icon_mobile"></i> Country Of Origin</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
         <?php while($user = $result_row->fetch_assoc()): ?>
				  <tr>
				    <td><?php echo ++$count ?></td>
                    <td><?=$user['course_reg_firstname']?> </td>
                    <td><?=$user['course_reg_surname']?></td>
                    <td><?=$user['course_reg_email']?></td>
                    <td><?=$user['course_reg_gender']?></td>
                    <td><?=$user['course_reg_country_origin']?></td>
                    <td><div class="btn-group">
                        <a class="btn btn-primary" href="reg_course_details.php?reg_id=<?=$user['course_reg_id']?>"><i class="icon_plus_alt2"></i> View Details</a>
                        </div>
                    </td>
                </tr>
				<?php endwhile?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
        
         <div class="row">
		<div class="col-lg-2 col-md-2"></div>
					<div class="col-lg-8 col-md-8">
	  <ul class="pagination mb-0 mt-50">
	<?php  if($page > 1){ ?> <li class='page-item'><a class='page-link' href='?page=1'><i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i> First</a></li><?php } ?>
    
	<li class='page-item' <?php if($page <= 1){ echo "class='disabled page-item'"; } ?>>
	<a class='page-link' <?php if($page > 1){ ?> href='?page=<?=$previous?>&course_id=<?=$course_id?>'<?php } ?>><i class="fa fa-angle-left"></i></a>
	</li>
       
    <?php 
	if ($pages <= 10){  	 
		for ($counter = 1; $counter <= $pages; $counter++){
			if ($counter == $page) {
		   echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
				}else{ ?> <li class='page-item' ><a class='page-link' href='?page=<?=$counter?>&course_id=<?=$course_id?>'><?=$counter?></a></li>
         <?php 	}
        }
	}
	elseif($pages > 10){
		
	if($page <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page) {
		   echo "<li class='active page-item'><a class='page-link' >$counter</a></li>";	
				}else{
           ?> <li class='page-item'><a class='page-link' href='?page=<?=$counter?>&course_id=<?=$course_id?>'><?=$counter?></a></li>
   <?php } } ?> 
     <li class='page-item' ><a class='page-link' >...</a></li>
		  <li class='page-item'><a class='page-link' href='?page=<?=$second_last?>&course_id=<?=$course_id?>'><?=$second_last?></a></li>
		  <li class='page-item'><a class='page-link' href='?page=<?=$pages?>&course_id=<?=$course_id?>'><?=$pages?></a></li>
		<?php }  elseif($page > 4 && $page < $pages - 4) { ?> 
		<li class='page-item'><a class='page-link' href='?page=1&course_id=<?=$course_id?>'>1</a></li>
		<li class='page-item'><a class='page-link' href='?page=2&course_id=<?=$course_id?>'>2</a></li>
    <li class='page-item'><a class='page-link'>...</a></li>
    <?php
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {			
           if ($counter == $page) { ?>
		   <li class='active page-item'><a class='page-link'><?=$counter?></a></li>	
			 <?php	}else{ ?>
          <li class='page-item'><a class='page-link' href='?page=<?=$counter?>&course_id=<?=$course_id?>'><?=$counter?></a></li>
       <?php	}   } ?>
        <li class='page-item'><a class='page-link' >...</a></li>
	      <li class='page-item'><a class='page-link' href='?page=<?=$second_last?>&course_id=<?=$course_id?>'><?=$second_last?></a></li>
	      <li class='page-item' ><a class='page-link' href='?page=<?=$pages?>&course_id=<?=$course_id?>'><?=$pages?></a></li>      
        <?php    } 	else { ?>
        <li class='page-item'><a class='page-link' href='?page=1&course_id=<?=$course_id?>'>1</a></li>
		    <li class='page-item'><a class='page-link' href='?page=2&course_id=<?=$course_id?>'>2</a></li>
        <li class='page-item' ><a class='page-link'>...</a></li>
        <?php
        for ($counter = $pages - 6; $counter <= $pages; $counter++) {
          if ($counter == $page) {
		   echo "<li class='active page-item'><a class='page-link' >$counter </a></li>";	
				}else{ ?>
          <li class='page-item'><a class='page-link' href='?page=<?=$counter?>&course_id=<?=$course_id?>'><?=$counter?></a></li>
				<?php }                   
        }
            }
	}
?>
    
	<li class='page-item' <?php if($page >= $pages){ echo "class='disabled page-item'"; } ?>>
	<a class='page-link' <?php if($page < $pages) { ?> href='?page=<?=$next?>&course_id=<?=$course_id?>'<?php } ?>><i class="fa fa-angle-right"></i></a>
	</li>
    <?php if($page < $pages){
	?> <li class='page-item'><a class='page-link'  href='?page=<?=$pages?>&course_id=<?=$course_id?>'>Last &rsaquo;&rsaquo;</a></li>
		<?php } ?>
</ul>
		</div>
 	</div>
 	
 	<div class="text-center">
 	    <a href="asfi_reg_course.php?course_id=<?=$course_id?>&Cleardb" class="btn btn-danger">Clear Course Registration Database</a>
 	</div>
        <!-- page end-->
      </section>
   <?php include_once ('footer.php');?>




    
