 <?php
 include ('../includes/db_connect.php');
 include('header.php');
  include('side_content.php');

  if(isset($_GET['course_id'])){
	$course_id = $_GET['course_id'];

	$result = $db->query("SELECT * FROM `courses` WHERE `course_id`= '$course_id'");
	    while($product = $result->fetch_assoc()): 
			 $course_title = $product['course_title'];
			 $course_duration = $product['course_duration'];
			 $course_target = $product['course_target'];
			 $course_image = $product['course_image'];
			 $course_details = $product['course_details'];
			 $course_link = $product['course_video_link'];
               $course_status = $product['course_status'];
               $course_price_variation = $product['course_price_variation'];
		endwhile; 
		
  }


  if(isset($_POST['price_variation_submit'])){


    $outside_africa = $_POST['outside_africa'];
    $outside_africa = strip_tags($outside_africa);
    $outside_africa = $db->real_escape_string($outside_africa);

    $african_non_members = $_POST['african_non_members'];
    $african_non_members = strip_tags($african_non_members);
    $african_non_members = $db->real_escape_string($african_non_members);

    $african_members = $_POST['african_members'];
    $african_members = strip_tags($african_members);
    $african_members = $db->real_escape_string($african_members);

    $nigerian_non_member = $_POST['nigerian_non_member'];
    $nigerian_non_member = strip_tags($nigerian_non_member);
    $nigerian_non_member = $db->real_escape_string($nigerian_non_member);

    $nigerian_members = $_POST['nigerian_members'];
    $nigerian_members = strip_tags($nigerian_members);
    $nigerian_members = $db->real_escape_string($nigerian_members);

    $with_code = $_POST['with_code'];
    $with_code = strip_tags($with_code);
    $with_code = $db->real_escape_string($with_code);


    $nigerian_with_code = $_POST['nigerian_with_code'];
    $nigerian_with_code = strip_tags($nigerian_with_code);
    $nigerian_with_code = $db->real_escape_string($nigerian_with_code);

    

    $price = array(
      'outside_africa' => $outside_africa,
      'african_non_members' => $african_non_members,
      'african_members' => $african_members,
      'nigerian_non_member' => $nigerian_non_member,
      'nigerian_members' => $nigerian_members,
      'with_code' => $with_code,
      'nigerian_with_code' => $nigerian_with_code,

    );	

    $price_list = json_encode($price,JSON_FORCE_OBJECT); 
    $query = $db->query("UPDATE `courses` SET `course_price_variation` = '$price_list' WHERE `courses`.`course_id` = '$course_id'");
    if($query){
      $_SESSION['alert'] = "Course Price Editted successfully";
      $_SESSION['alert_code'] = "success";
      $_SESSION['alert_link'] = "";
    }else{
      $_SESSION['alert'] = "Course Price Not Editted";
      $_SESSION['alert_code'] = "warning";
      $_SESSION['alert_link'] = "";
    }
  }

  if(isset($_POST['editCourse'])){
    
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
    
    $course_status = $_POST['course_status'];
    $course_status = strip_tags($course_status);
    $course_status = $db->real_escape_string($course_status);


    if(empty($course_title)){
      # code...
      $_SESSION['alert'] = "Please kindly fill in all fields";
      $_SESSION['alert_code'] = "warning";
      $_SESSION['alert_link'] = "";
 
    }else{


		if(empty($imageName)){
			$query = $db->query("UPDATE `courses` SET `course_title` = '$course_title', `course_duration` = '$course_duration ', `course_target` = '$course_target', `course_details` = '$course_details', `course_video_link` = '$course_link', `course_status` = '$course_status' WHERE `courses`.`course_id` = '$course_id'");
           
      if($query){
				$_SESSION['alert'] = "Course Editted successfully";
				$_SESSION['alert_code'] = "success";
				$_SESSION['alert_link'] = "";
			}else{
				$_SESSION['alert'] = "Course Editted successfully";
				$_SESSION['alert_code'] = "warning";
				$_SESSION['alert_link'] = "";
			}

		}else{

			$target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
			$query = $db->query("UPDATE `courses` SET `course_title` = '$course_title', `course_duration` = '$course_duration ', `course_target` = '$course_target', `course_image` = '$imageName', `course_details` = '$course_details',  `course_video_link` = '$course_link', `course_status` = '$course_status' WHERE `courses`.`course_id` = '$course_id'");
           
            if($query){
                // Check if file already exists
                if (file_exists($target_file)) {
					$_SESSION['alert'] = "Image Not Changed successfully";
					$_SESSION['alert_code'] = "success";
					$_SESSION['alert_link'] = "";
                
                }else{
                    // Check file size
                    if ($_FILES["image"]["size"] > 5000000) {
                    $_SESSION['alert'] = " Sorry, your image is larger than 5mb.";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = "";
                        
                    }else{
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp" ) {
                        $_SESSION['alert'] = " Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                        $_SESSION['alert_code'] = "warning";
                        $_SESSION['alert_link'] = "";
                        
                        }else{
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                               
                                $_SESSION['alert'] = "Image Changed successfully.";
                                $_SESSION['alert_code'] = "success";
                                $_SESSION['alert_link'] = "";
                            
                            } else {
                                $_SESSION['alert'] = " Sorry, there was an error uploading your image";
                                $_SESSION['alert_code'] = "error";
                                $_SESSION['alert_link'] = "";
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
}

 ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Courses</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
			  <li><i class="fa fa-home"></i><a href="courses.php">Courses</a></li>
              <li><i class="fa fa-bars"></i><?=$course_title?></li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>COURSES</h2>
                    </div>
     	</div>
	<div class="row">
	      <div class="col-md-12">
                        <h4>Edit <?=$course_title?> </h4>
                    </div>          
                       
    </div>
				 <br>
		<div class="row">
			<div class="col-lg-1 col-md-1"></div>
			<div class="col-lg-10 col-md-10">
			<form action="" method="post" enctype="multipart/form-data">
                        
							<div class="input-group">                      
								<label> Course Title: <input type="text" value="<?=$course_title?>" name="course_title" class="form-control"  required/></label>
							</div>
						
              				<div class="input-group">                      
								<label> Course Duration: <input type="text" value="<?=$course_duration?>" name="course_duration" class="form-control"  required/></label>
							</div>
						

             				 <div class="input-group">                      
								<label> Course Target: <input type="text" value="<?=$course_target?>" name="course_target" class="form-control"  required/></label>
							</div>
						

							<div class="input-group">
								<label> Course Details <textarea class="form-control "  name="course_details"><?=$course_details?></textarea></label>
																			<script>
																					CKEDITOR.replace('course_details');
																			</script>
							</div>
                              <br>
                                  <div class="input-group">
                                  <a href=""  data-toggle="modal" data-target="#course_price" class="btn btn-danger" title="Course Price"> <span>Course Price Variation</span></a>                                           
                                  </div>
                                  <br>
                                  <div class="input-group">                      
								<label> Course Youtube Testimonial Link: <input type="text" name="course_link" value="<?=$course_link?>" class="form-control"  /></label>
							</div>
							
							<img src="img/courses/<?=$course_image?>" width="100px">
							<div class="input-group">
								<label> Upload an image of Course <input type="file"  name="image" class="form-control" /></label>
								<p>Please Note Image size should be below <span style="color:red;">1MB </span>and Image Dimension is <span style="color:red;">1024x768px </span> </p>
							</div>
							
							<br>
							
							<div class="input-group">                      
								<label> Course Status:
								<select class="form-control"  name="course_status">
								    <option value="<?=$course_status?>" ><?=$course_status?></option>
								    <option value="" >=== Change Status === </option>
								    <option value="" > Not Active </option>
								     <option value="active"> Active </option>
								</select>
							</div>
						
						   <br>
                               <div class="input-group">
                                  <input type="submit" name="editCourse" value="Submit Changes" class="btn btn-primary form-control" />
                                </div>
                       </form>	 
                    
			</div>
		</div>
					
				
                <!-- /. ROW  -->
        <!-- page end-->
      </section>
    </section>
    <?php include('footer.php'); ?>

    <!-- Modal -->
  <div id="course_price" class="modal fade" role="dialog">
  <div class="modal-dialog">

  <?php
        if(!empty($course_price_variation)){
          $course_price_variation = json_decode($course_price_variation, true);
        }else{
          $course_price_variation = array();
        }
  
  ?>

     <!-- Modal content-->
     <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Course Price Variation</h4>
      </div>
      <div class="modal-body">
            <div class="panel panel-primary">
                 
                            <div class="panel-body">
                     		<form action="" method="post" enctype="multipart/form-data">
                        
                          <div class="input-group">                      
                            <label> Outside Africa ($): <input type="text" value="<?=$course_price_variation['outside_africa']?>" name="outside_africa" class="form-control"  required/></label>
                          </div>
                        
                          <div class="input-group">                      
                            <label>African But Non-ASFI Members ($): <input type="text" value="<?=$course_price_variation['african_non_members']?>" name="african_non_members" class="form-control" /></label>
                          </div>

                          <div class="input-group">                      
                            <label>African ASFI Members ($): <input type="text" value="<?=$course_price_variation['african_members']?>" name="african_members" class="form-control"  /></label>
                          </div>

                          <div class="input-group">                      
                            <label>Nigerian Non-ASFI Members (₦): <input type="text" value="<?=$course_price_variation['nigerian_non_member']?>" name="nigerian_non_member" class="form-control"  /></label>
                          </div>

                          <div class="input-group">                      
                            <label>Nigerian ASFI Members (₦): <input type="text" value="<?=$course_price_variation['nigerian_members']?>" name="nigerian_members" class="form-control"  /></label>
                          </div>

                          <div class="input-group">                      
                            <label>With Discount Code Price ($): <input type="text" value="<?=$course_price_variation['with_code']?>" name="with_code" class="form-control"  /></label>
                          </div>

                          <div class="input-group">                      
                            <label>Nigerian With Discount Code Price (₦): <input type="text" value="<?=$course_price_variation['nigerian_with_code']?>" name="nigerian_with_code" class="form-control"  /></label>
                          </div>
						
                            <div class="input-group">
                                  <input type="submit" name="price_variation_submit" value="SUBMIT" class="btn btn-primary form-control" />
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

 