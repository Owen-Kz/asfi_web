<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

if(isset($_POST['category_add'])){
    
    $target_dir = "img/business-categories/";
    $imageName =  basename($_FILES["image"]["name"]);

	$title = $_POST['title'];
	$title = strip_tags($title);
	$title = $db->real_escape_string($title);
	

    if(empty($title)){
      # code...
      $_SESSION['alert'] = "Please kindly fill in all fields";
      $_SESSION['alert_code'] = "warning";
      $_SESSION['alert_link'] = "";
 
    }else{

            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
			$query = $db->query("INSERT INTO business_category (buz_category_title, buz_category_image) 
			VALUES('$title', '$imageName')");
            
            if($query){
                // Check if file already exists
                if (file_exists($target_file)) {
                $_SESSION['alert'] = "Business Category added successfully";
                $_SESSION['alert_code'] = "success";
                $_SESSION['alert_link'] = "";
                
                }else{
                    // Check file size
                    if ($_FILES["image"]["size"] > 5000000) {
                    $_SESSION['alert'] = "Business Category added successfully But Sorry, your image is larger than 5mb.";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = "";
                        
                    }else{
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        $_SESSION['alert'] = "Business Category added successfully But Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                        $_SESSION['alert_code'] = "warning";
                        $_SESSION['alert_link'] = "";
                        
                        }else{
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                               
                                $_SESSION['alert'] = "Business Category added successfully";
                                $_SESSION['alert_code'] = "success";
                                $_SESSION['alert_link'] = "";
                            
                            } else {
                                $_SESSION['alert'] = "Sorry, there was an error uploading your file";
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


if(isset($_GET['action'])){

	if($_GET['action'] == 'delete'){
		
		$testimony_id = $_GET['testimony_id'];

		$delete = $db->query("DELETE FROM `testimonials` WHERE `testimonials`.`id` = $testimony_id");
	
		if($delete){

			$_SESSION['alert'] = "testimonials Deleted";
			$_SESSION['alert_code'] = "success";
			$_SESSION['alert_link'] = "testimonies.php";
		}
	}		
}

?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Business Categories</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Business Categories</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>Business Categories</h2>
                    </div>
     </div>
	<div class="row">
	      <div class="col-md-12">
                        <h4>Add New Business Categories <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newArticle">Click Here</button> </h4>
					</div>                       
    </div>
				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_testimony = $db->query("SELECT * FROM business_category ORDER BY buz_category_id DESC");
		             ?> 
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Business Categories Title</th>
                                    <th>Business Categories Count</th>
									<th>Action</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($testimony = $result_testimony->fetch_assoc()): ?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$testimony['buz_category_title']?></td>
			                         <td></td>
									 <td> <a href="?buz_category_id=<?=$testimony['buz_category_id']?>&action=delete"class="btn btn-danger">Delete</a></td>
		                         </tr>
							
                            </tbody>
							<?php endwhile?>
                        </table>
			
               </div>
        
					
				
                <!-- /. ROW  -->
        <!-- page end-->
      </section>
    </section>
</section>		   
		   <!-- Modal -->
			

                <!-- /. ROW  -->
	 
	 <?php include_once ('footer.php');?>

	 <div id="newArticle" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-full_name">Add Business Categories</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label> Business Categories Title: <input type='text' name='title' class='form-control' required /></label>
													</div>

													<div class='input-group'>                      
														<label> Business Categories Image: <input type='file' name='image' class='form-control'  /></label>
													</div>
		
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='category_add' value='Add' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>  