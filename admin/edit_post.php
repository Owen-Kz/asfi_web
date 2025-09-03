<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

if(!isset($_GET['pid'])){
	header('Location: post.php');
	exit();	
}else{
	$pid = $_GET['pid'];

	$result = $db ->query("SELECT * FROM posts WHERE post_id=$pid");
    while($post = $result->fetch_assoc()):
        $post_author = $post['post_author'];
        $post_title = $post['post_title'];
        $post_body = $post['post_body'];
        $post_image = $post['post_image'];
        $category = $post['category'];

    endwhile;

	if(isset($_POST['update'])){
    
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
	
	
	
		if(empty($title)){
		  # code...
		  $_SESSION['alert'] = "Please kindly fill in all fields";
		  $_SESSION['alert_code'] = "warning";
		  $_SESSION['alert_link'] = "";
	 
		}else{
			if(empty($imageName)){
				$query = $db->query("UPDATE `posts` SET `post_author` = '$post_author', `post_title` = '$title', `post_body` = '$body',  `category` = '$select_category' WHERE `posts`.`post_id` = $pid");
					if($query){
					   
						$_SESSION['alert'] = "Blog Post Editted successfully";
						$_SESSION['alert_code'] = "success";
						$_SESSION['alert_link'] = "";
									
				   } else {
						$_SESSION['alert'] = "Sorry, Blog Post Not Editted";
						$_SESSION['alert_code'] = "error";
						$_SESSION['alert_link'] = "";
					}
				
			}else{
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
				$query = $db->query("UPDATE `posts` SET `post_author` = '$post_author', `post_title` = '$title', `post_body` = '$body', `post_image` = '$imageName', `category` = '$select_category' WHERE `posts`.`post_id` = $pid");
				
				if($query){
					// Check if file already exists
					if (file_exists($target_file)) {
					$_SESSION['alert'] = "Blog Post Editted successfully But Sorry, image already exists.";
					$_SESSION['alert_code'] = "warning";
					$_SESSION['alert_link'] = "";
					
					}else{
						// Check file size
						if ($_FILES["image"]["size"] > 5000000) {
						$_SESSION['alert'] = "Blog Post Editted successfully But Sorry, your image is larger than 5mb.";
						$_SESSION['alert_code'] = "warning";
						$_SESSION['alert_link'] = "";
							
						}else{
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
							$_SESSION['alert'] = "Blog Post Editted successfully But Sorry, only JPG, JPEG, PNG & GIF files are allowed";
							$_SESSION['alert_code'] = "warning";
							$_SESSION['alert_link'] = "";
							
							}else{
								if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
								   
									$_SESSION['alert'] = "Blog Post Editted successfully";
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
	}

}
?>

<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Edit Blog</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
			  <li><i class="fa fa-home"></i><a href="index.php">blog</a></li>
              <li><i class="fa fa-bars"></i>Edit Blog</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>EDIT <?=$post_title?></h2>
                    </div>
     </div>
				 <br>
				 <div class="row">
	
	<div class="col-lg-2 col-md-2"></div>
	<div class="col-lg-8 col-md-8">
		
		
		<div class="panel panel-primary">
			<div class="panel-heading">
			   Edit posts
			</div>
			
			
			<div class="panel-body">
				<form action="<?php echo $_SERVER['PHP_SELF']?>?pid=<?=$pid?>" method="post" enctype="multipart/form-data">
	  <div class="input-group">
											
		 </div>
		
		<div class="input-group">                      
				<label> Author: <input type="text" name="post_author" class="form-control" value="<?=$post_author?>" /></label>
			</div>
		<div class="input-group">                      
				<label> Title: <input type="text" name="post_title" class="form-control" value="<?=$post_title?>" /></label>
			</div>

	
		
		<img src= "img/posts/<?=$post_image?>" width="100px" >
		<div class="input-group">
			  <label>Change Image <input type="file" name="image"  class="form-control" /></label>
		 </div>
		 <div class="input-group">                      
									  
			  <label>Change Category </label><select name="select_category" class="form-control">
			  		<option value='<?=$category?>'><?=$category?></option>
				  <option value="">========</option>
				  <option value='News'>NEWS</option>
				  <option value='Articles'>ARTICLES</option>
				  <option value='Updates'>UPDATES</option> 
			  </select>
		</div>
		<div class="input-group">
			  <label> Body  
			  				<textarea class="form-control "  name="post_body"><?=$post_body?></textarea></label>
								<script>
										CKEDITOR.replace( 'post_body' );
								</script>
			
			</label>
		</div>
			</div>
			<div class="panel-footer">
			   <div class="input-group">
				  <input type="submit" name="update" value="Update" class="btn btn-primary form-control" />
				</div>
			</div>
	   </form>	


	   
	</div>
	
</div>
				
                <!-- /. ROW  -->
        <!-- page end-->
      </section>
    </section>
</section>
                <!-- /. ROW  -->
	 
	 <?php include_once ('footer.php');?>
    