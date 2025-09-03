<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');


if(isset($_POST['post_add'])){
    
    $target_dir = "img/posts/";
    $imageName =  basename($_FILES["image"]["name"]);

	$title = $_POST['post_title'];
	$title = strip_tags($title);
	$title = $db->real_escape_string($title);
	
	$post_author = $_POST['post_author'];
	$post_author = strip_tags($post_author);
	$post_author = $db->real_escape_string($post_author);
	
	$body = $_POST['post_body'];
	$body = $db->real_escape_string($body);	
	
	$select_category = $_POST['select_category'];
	$select_category = strip_tags($select_category);
	$select_category = $db->real_escape_string($select_category );

	$date = date('Y-m-d');
	
	
	$admin_id = $_SESSION['admin_id'];

    if(empty($title)){
      # code...
      $_SESSION['alert'] = "Please kindly fill in all fields";
      $_SESSION['alert_code'] = "warning";
      $_SESSION['alert_link'] = "";
 
    }else{

            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
			$query = $db->query("INSERT INTO posts (post_author, post_title, post_body, post_image, post_date, category) 
			VALUES('$post_author', '$title', '$body', '$imageName', '$date', '$select_category')");
            
            if($query){
                // Check if file already exists
                if (file_exists($target_file)) {
                $_SESSION['alert'] = "Blog Post added successfully But Sorry, image already exists.";
                $_SESSION['alert_code'] = "warning";
                $_SESSION['alert_link'] = "";
                
                }else{
                    // Check file size
                    if ($_FILES["image"]["size"] > 5000000) {
                    $_SESSION['alert'] = "Blog Post added successfully But Sorry, your image is larger than 5mb.";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = "";
                        
                    }else{
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        $_SESSION['alert'] = "Blog Post added successfully But Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                        $_SESSION['alert_code'] = "warning";
                        $_SESSION['alert_link'] = "";
                        
                        }else{
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                               
                                $_SESSION['alert'] = "Blog Post added successfully";
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
		
		$post_id = $_GET['post_id'];

		$delete = $db->query("DELETE FROM `posts` WHERE `posts`.`post_id` = $post_id");
	
		if($delete){

			$_SESSION['alert'] = "Blog Post Deleted";
			$_SESSION['alert_code'] = "success";
			$_SESSION['alert_link'] = "post.php";
		}
	}		
}





?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Blog</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Blog</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>Blog</h2>
                    </div>
     </div>
	<div class="row">
	    <div class="col-md-12">
            <h4>Add New Blog <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newArticle">Click Here</button> </h4>
        </div>          
    </div>
				 <br>
	<div class="row">
		<div class="col-lg-1 col-md-1"></div>
		<div class="col-lg-10 col-md-10">
					<?php 
					 $result_post = $db->query("SELECT * FROM posts ORDER BY post_id DESC");
		             ?> 
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Post title</th>
                                    <th>Date and Time</th>
									<th>Category</th>
									<th>Action</th>
                                    <th>Live Details</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($post = $result_post->fetch_assoc()): ?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$post['post_title']?></td>
			                         <td><?=$post['post_date']?></td>
									 
									  
                                    <td> <?=$post['category']?></td>
				                 
									 <td><a href="edit_post.php?pid=<?=$post['post_id']?>"class="btn btn-primary">Edit</a> <a href="?post_id=<?=$post['post_id']?>&action=delete"class="btn btn-danger">Delete</a></td>
									 <td> <a href="../news-details.php?blog_id=<?=$post['post_id']?>"class="btn btn-primary">Live Preview</a></td>
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
						<h4 class="modal-title">Add News, Articles & Updates</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label> Title: <input type='text' name='post_title' class='form-control' required /></label>
													</div>
													
													<div class='input-group'>                      
														<label> Author: <input type='text' name='post_author' class='form-control' required /></label>
													</div>

													

													<div class="input-group">
														<label> Body:  
																		<textarea class="form-control "  name="post_body"></textarea></label>
																			<script>
																					CKEDITOR.replace( 'post_body' );
																			</script>
														
														</label>
													</div>
																				
													<div class='input-group'>
														<label> Upload cover image for post <input type='file' name='image' class='form-control' required /></label>
														<p>Please Note Image size should be below <span style='color:red;'>1MB </span>and Image Dimension is <span style='color:red;'>1024x768px </span> </p>
													</div>
										
								
													<div class='input-group'>                      
														<label>Select Category </label>
														<select name='select_category' class='form-control' required>
														<option value='News'>NEWS</option>
														<option value='Articles'>ARTICLES</option>
														<option value='Updates'>UPDATES</option>
														</select>
													</div>
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='post_add' value='Add' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>  