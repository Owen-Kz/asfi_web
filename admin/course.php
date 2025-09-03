 <?php
 include ('../includes/db_connect.php');
 include('header.php');
  include('side_content.php');

  if(isset($_POST['submitcourse'])){
    
    $target_dir = "img/courses/";
    $imageName =  basename($_FILES["image"]["name"]);

    $course_title = $_POST['course_title'];
    $course_title = strip_tags($course_title);
    $course_title = $db->real_escape_string($course_title);

    $course_details = $_POST['course_details'];
    $course_details = $db->real_escape_string($course_details);


    $course_duration = $_POST['course_duration'];
    $course_duration = strip_tags($course_duration);
    $course_duration = $db->real_escape_string($course_duration);

    $course_target = $_POST['course_target'];
    $course_target = strip_tags($course_target);
    $course_target = $db->real_escape_string($course_target);


    $course_link = $_POST['course_link'];
    $course_link = strip_tags($course_link);
    $course_link = $db->real_escape_string($course_link);
	

    if(empty($course_title)){
      # code...
      $_SESSION['alert'] = "Please kindly fill in all fields";
      $_SESSION['alert_code'] = "warning";
      $_SESSION['alert_link'] = "";
 
    }else{

            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
			$query = $db->query("INSERT INTO courses (course_title, course_duration, course_target, course_image, course_details, course_video_link, course_status) 
			                    VALUES('$course_title', '$course_duration', '$course_target', '$imageName', '$course_details', '$course_link', '')");
           
            if($query){
                // Check if file already exists
                if (file_exists($target_file)) {
                $_SESSION['alert'] = "Course added successfully";
                $_SESSION['alert_code'] = "success";
                $_SESSION['alert_link'] = "course.php";
                
                }else{
                    // Check file size
                    if ($_FILES["image"]["size"] > 5000000) {
                    $_SESSION['alert'] = "Course added successfully But Sorry, your image is larger than 5mb.";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = "course.php";
                        
                    }else{
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp" ) {
                        $_SESSION['alert'] = "Course added successfully But Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                        $_SESSION['alert_code'] = "warning";
                        $_SESSION['alert_link'] = "course.php";
                        
                        }else{
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                               
                                $_SESSION['alert'] = "Your Course has been added successfully.";
                                $_SESSION['alert_code'] = "success";
                                $_SESSION['alert_link'] = "course.php";
                            
                            } else {
                                $_SESSION['alert'] = "Course added successfully But Sorry, there was an error uploading your image";
                                $_SESSION['alert_code'] = "error";
                                $_SESSION['alert_link'] = "course.php";
                            }
                        }
                    }
                }
            }else{
                $_SESSION['alert'] = "Sorry, there was an error uploading your file";
                $_SESSION['alert_code'] = "error";
                $_SESSION['alert_link'] = "";
            }
      
    }
}


?>

 ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Courses</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Courses</li>
            </ol>
          </div>
        </div>
        <!-- page start-->


	<div class="box-header with-border">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="GET">
                  <div class="form-group">
                    <input type="text" class="form-control" name="product_search"  placeholder="Search Products">
                  </div> 
                  <div class="form-group">
                    <input type="submit" name="search_product" class="btn btn-success" value="search">
                  </div> 
                </form>
                <div class="pull-right">
                    <a href="" id="new-person-btn" data-toggle="modal" data-target="#new" class="btn btn-primary" title="New Product"><div class=''><i class='fa fa-plus '></i> <span>Add New Course</span></div></a>                                           
                </div>
            </div>
        </div>
    </div><!-- /.box-header -->
				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">

<?php 
		
		  $limit = 20;
	if(isset($_GET['search_product'])){
		
		  $search = $_GET['product_search'];

		  $page = isset($_GET['page']) ? $_GET['page'] : 1;
		  $start = ($page - 1) * $limit;
		  $end = $start + $limit;
		  $result_row = $db->query("SELECT * FROM courses  WHERE course_title LIKE '%".$search."%'  LIMIT $start, $limit");
		  $resultCount = $db->query("SELECT * FROM courses  WHERE course_title LIKE '%".$search."%' ");
		  $countAll = $resultCount->num_rows;
		  $pages = ceil( $countAll / $limit );

		  $next = $page + 1;
		  $previous = $page - 1;
		  $adjacents = "2"; 
		  $second_last = $pages - 1; // total page minus 1
	}else{

		  $page = isset($_GET['page']) ? $_GET['page'] : 1;
		  $start = ($page - 1) * $limit;
		  $end = $start + $limit;
		  $result_row = $db->query("SELECT * FROM courses  LIMIT $start, $limit");
		  $resultCount = $db->query("SELECT * FROM courses");
		  $countAll = $resultCount->num_rows;
		  $pages = ceil( $countAll / $limit );

		  $next = $page + 1;
		  $previous = $page - 1;
		  $adjacents = "2"; 
		  $second_last = $pages - 1; // total page minus 1
	}
	
	$count = 0;


  $resultCount = $db->query("SELECT * FROM courses");
  $countAll = $resultCount->num_rows;
 
?>
			    
					   <h3>All Courses</h3>
					  
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Course Title</th>
									<th>Course Duration</th>
									<th>Course Registered</th>
									<th>Action</th>
   
                                </tr>
                            </thead>
                            
							<?php while($product = $result_row->fetch_assoc()): ?>
							
							<tbody>
							  <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?=$product['course_title']?></td>
									 <td><?=$product['course_duration']?></td>
                <?php 
                    $cid = $product['course_id'];
                    $regCourseCount = $db->query("SELECT * FROM course_registration WHERE course_reg_course_id = $cid");
                    $countCourse = $regCourseCount->num_rows;
                ?>
									 <td> <a href="asfi_reg_course.php?course_id=<?=$product['course_id']?>"><?=$countCourse?></a></td>
									<td>
									 <div class="btn-group">
									   
										<a class="btn btn-primary btn-sm view-data" href="course_edit.php?course_id=<?=$product['course_id']?>" ><i class="icon_plus_alt2"></i> Edit Course</a> <a class="btn btn-danger btn-sm" href="course_del.php?course_id=<?=$product['course_id']?>"><i class="icon_close_alt2"></i> Delete Course</a>
									  </div>
									</td>
							  </tr>
                             
                            </tbody>
							<?php endwhile?>
                        </table>
					 
					 
					 
					 </div>
        </div>
        
					
				
                <!-- /. ROW  -->
        <!-- page end-->
      </section>
 <div class="row">
		<div class="col-lg-2 col-md-2"></div>
					<div class="col-lg-8 col-md-8">
	  <ul class="pagination mb-0 mt-50">
	<?php  if($page > 1){ ?> <li class='page-item'><a class='page-link' href='?page=1'><i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i> First</a></li><?php } ?>
    
	<li class='page-item' <?php if($page <= 1){ echo "class='disabled page-item'"; } ?>>
	<a class='page-link' <?php if($page > 1){ ?> href='?page=<?=$previous?>'<?php } ?>><i class="fa fa-angle-left"></i></a>
	</li>
       
    <?php 
	if ($pages <= 10){  	 
		for ($counter = 1; $counter <= $pages; $counter++){
			if ($counter == $page) {
		   echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
				}else{ ?> <li class='page-item' ><a class='page-link' href='?page=<?=$counter?>'><?=$counter?></a></li>
         <?php 	}
        }
	}
	elseif($pages > 10){
		
	if($page <= 4) {			
	 for ($counter = 1; $counter < 8; $counter++){		 
			if ($counter == $page) {
		   echo "<li class='active page-item'><a class='page-link' >$counter</a></li>";	
				}else{
           ?> <li class='page-item'><a class='page-link' href='?page=<?=$counter?>'><?=$counter?></a></li>
   <?php } } ?> 
     <li class='page-item' ><a class='page-link' >...</a></li>
		  <li class='page-item'><a class='page-link' href='?page=<?=$second_last?>'><?=$second_last?></a></li>
		  <li class='page-item'><a class='page-link' href='?page=<?=$pages?>'><?=$pages?></a></li>
		<?php }  elseif($page > 4 && $page < $pages - 4) { ?> 
		<li class='page-item'><a class='page-link' href='?page=1 '>1</a></li>
		<li class='page-item'><a class='page-link' href='?page=2'>2</a></li>
    <li class='page-item'><a class='page-link'>...</a></li>
    <?php
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {			
           if ($counter == $page) { ?>
		   <li class='active page-item'><a class='page-link'><?=$counter?></a></li>	
			 <?php	}else{ ?>
          <li class='page-item'><a class='page-link' href='?page=<?=$counter?>'><?=$counter?></a></li>
       <?php	}   } ?>
        <li class='page-item'><a class='page-link' >...</a></li>
	      <li class='page-item'><a class='page-link' href='?page=<?=$second_last?>'><?=$second_last?></a></li>
	      <li class='page-item' ><a class='page-link' href='?page=<?=$pages?>'><?=$pages?></a></li>      
        <?php    } 	else { ?>
        <li class='page-item'><a class='page-link' href='?page=1'>1</a></li>
		    <li class='page-item'><a class='page-link' href='?page=2'>2</a></li>
        <li class='page-item' ><a class='page-link'>...</a></li>
        <?php
        for ($counter = $pages - 6; $counter <= $pages; $counter++) {
          if ($counter == $page) {
		   echo "<li class='active page-item'><a class='page-link' >$counter </a></li>";	
				}else{ ?>
          <li class='page-item'><a class='page-link' href='?page=<?=$counter?>'><?=$counter?></a></li>
				<?php }                   
        }
            }
	}
?>
    
	<li class='page-item' <?php if($page >= $pages){ echo "class='disabled page-item'"; } ?>>
	<a class='page-link' <?php if($page < $pages) { ?> href='?page=<?=$next?>'<?php } ?>><i class="fa fa-angle-right"></i></a>
	</li>
    <?php if($page < $pages){
	?> <li class='page-item'><a class='page-link'  href='?page=<?=$pages?>'>Last &rsaquo;&rsaquo;</a></li>
		<?php } ?>
</ul>
		</div>
 	</div>

    </section>
    <?php
 
 include('footer.php');
 ?>
 
 
    <!-- Modal -->
 <div id="new" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Course</h4>
      </div>
      <div class="modal-body">
            <div class="panel panel-primary">
                 
                            <div class="panel-body">
                     		<form action="" method="post" enctype="multipart/form-data">
                        
							<div class="input-group">                      
								<label> Course Title: <input type="text" name="course_title" class="form-control"  required/></label>
							</div>
						
              <div class="input-group">                      
								<label> Course Duration: <input type="text" name="course_duration" class="form-control"  required/></label>
							</div>
						

              <div class="input-group">                      
								<label> Course Target: <input type="text" name="course_target" class="form-control"  required/></label>
							</div>
						

							<div class="input-group">
								<label> Course Details <textarea class="form-control "  name="course_details"></textarea></label>
																			<script>
																					CKEDITOR.replace('course_details');
																			</script>
							</div>

              <div class="input-group">                      
								<label> Course Youtube Testimonial Link: <input type="text" name="course_link" class="form-control"  /></label>
							</div>
							
							<div class="input-group">
								<label> Upload an image of Course <input type="file" required name="image" class="form-control" /></label>
								<p>Please Note Image size should be below <span style="color:red;">1MB </span>and Image Dimension is <span style="color:red;">1024x768px </span> </p>
							</div>
							

						   <br>
                            <div class="input-group">
                                  <input type="submit" name="submitcourse" value="SUBMIT" class="btn btn-primary form-control" />
                            </div>

                            </div>
                       </form>	 
                    </div>
						
        </div>
    </div>
                     
   </div>
</div>

  </div>
</div>

