<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

if(!isset($_GET['event_id'])){
	header('Location: events.php');
	exit();	
}
	$event_id = $_GET['event_id'];
	$result="";
	


if(isset($_POST['update'])){
	//location of file
	$target = "img/events/".basename($_FILES['image']['name']);
	// get data from form
	$image = $_FILES['image']['name'];
	
	$event_title = $_POST['event_title'];
	$event_title = strip_tags($event_title);
	$event_title = $db->real_escape_string($event_title);
	
	$event_date = $_POST['event_date'];
	$event_date = strip_tags($event_date);
	$event_date = $db->real_escape_string($event_date);
	
	$event_time = $_POST['event_time'];
	$event_time = strip_tags($event_time);
	$event_time = $db->real_escape_string($event_time);
	
	$event_location = $_POST['event_location'];
	$event_location = strip_tags($event_location);
	$event_location = $db->real_escape_string($event_location);
	
	
	$event_link = $_POST['event_link'];
	$event_link = strip_tags($event_link);
	$event_link = $db->real_escape_string($event_link);
	
	
	$event_details = $_POST['event_details'];
	$event_details = $db->real_escape_string($event_details);
	
	
	
	if(empty($event_title) || empty($event_date)){
		echo "<script>alert('Please Fill all Field'); </script>";
	}else{
	    if(!empty($image)){
			
		    $query = $db->query("UPDATE `events` SET `event_title` = '$event_title', `event_date` = '$event_date', `event_time` = '$event_time', `event_location` = '$event_location', `event_link` = '$event_link', `event_details` = '$event_details', `event_image` = '$image' WHERE `events`.`event_id` = $event_id");
		
		    if($query){
		        // move image
		           if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
					 echo "<script>alert('Image Change successfully'); </script>";
		            }else{
						echo "<script>alert('Image Change Unsuccessful Please Try Again'); </script>";
		             }
		       }
	    }else{
			 $query2 = $db->query("UPDATE `events` SET `event_title` = '$event_title', `event_date` = '$event_date', `event_time` = '$event_time', `event_location` = '$event_location', `event_link` = '$event_link', `event_details` = '$event_details' WHERE `events`.`event_id` = $event_id");
		     if($query2){
				echo "<script>alert('Edited Successfully'); </script>";
			 }
		}
	}
	
}

if(isset($_POST['speaker_submit'])){
    
    $target_dir = "img/event_speaker/";
    $imageName =  basename($_FILES["image"]["name"]);

	$speaker_names = $_POST['speaker_names'];
	$speaker_names = strip_tags($speaker_names);
	$speaker_names = $db->real_escape_string($speaker_names);
	
	$speaker_position = $_POST['speaker_position'];
	$speaker_position = strip_tags($speaker_position);
	$speaker_position = $db->real_escape_string($speaker_position);
	

    if(empty($speaker_names)){
      # code...
      $_SESSION['alert'] = "Please kindly fill in all fields";
      $_SESSION['alert_code'] = "warning";
      $_SESSION['alert_link'] = "";
 
    }else{

            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
			$query = $db->query("INSERT INTO events_speakers (event_id, speaker_names, speaker_position, speaker_image) 
			VALUES('$event_id', '$speaker_names', '$speaker_position', '$imageName')");
            
            if($query){
                // Check if file already exists
                if (file_exists($target_file)) {
                $_SESSION['alert'] = "Speaker added successfully But Sorry, image already exists.";
                $_SESSION['alert_code'] = "warning";
                $_SESSION['alert_link'] = "";
                
                }else{
                    // Check file size
                    if ($_FILES["image"]["size"] > 5000000) {
                    $_SESSION['alert'] = "Speaker added successfully But Sorry, your image is larger than 5mb.";
                    $_SESSION['alert_code'] = "warning";
                    $_SESSION['alert_link'] = "";
                        
                    }else{
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        $_SESSION['alert'] = "Speaker added successfully But Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                        $_SESSION['alert_code'] = "warning";
                        $_SESSION['alert_link'] = "";
                        
                        }else{
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                               
                                $_SESSION['alert'] = "Speaker added successfully";
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
		
		$speaker_id = $_GET['speaker_id'];

		$delete = $db->query("DELETE FROM `events_speakers` WHERE `events_speakers`.`speaker_id` = $speaker_id");
	
		if($delete){

			$_SESSION['alert'] = "Speaker Removed";
			$_SESSION['alert_code'] = "success";
			$_SESSION['alert_link'] = "?event_id=$event_id";
		}
	}		
}

?>

<section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Edit Events</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
			  <li><i class="fa fa-book"></i><a href="events.php">Events</a></li>
              <li><i class="fa fa-bars"></i>Edit Events</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>EDIT Events</h2>
                    </div>
     	</div>
				 <br>
		<div class="row">
	
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-8 col-md-8">
				
				
		<div class="panel panel-primary">
			<div class="panel-heading">
			   Edit Events
			</div>
			
			
			<div class="panel-body">
				<form action="<?php echo $_SERVER['PHP_SELF']?>?event_id=<?=$event_id?>" method="post" enctype="multipart/form-data">
					<div class="input-group">
						<p><?=$result?></p> 
					</div>
					<?php 
						$result_event = $db->query("SELECT * FROM events WHERE event_id=$event_id ");
						?>
		 				<?php while($event = $result_event->fetch_assoc()): ?>
	
							<div class='input-group'>                      
									<label>Events Title: <input type='text' name='event_title' class='form-control'  value="<?=$event['event_title']?>" /></label>
							</div>
																		
							<div class='input-group'>                      
								<label> Event Date: <input type='date' name='event_date' class='form-control'  value="<?=$event['event_date']?>" /></label>
							</div>
							<div class='input-group'>                      
								<label> Event Time: <input type='time' name='event_time' class='form-control'  value="<?=$event['event_time']?>" /></label>
							</div>
							<div class='input-group'>                      
								<label> Event Location: <input type='text' name='event_location' class='form-control' value="<?=$event['event_location']?>" /></label>
							</div>
							
							<div class='input-group'>                      
								<label> Event Link: <input type='text' name='event_link' class='form-control' value="<?=$event['event_link']?>" /></label>
							</div>
							
						
							
								<div class="input-group">
								<label> Event Details <textarea class="form-control "  name="event_details"><?=$event['event_details']?></textarea></label>
																			<script>
																					CKEDITOR.replace('event_details');
																			</script>
							</div>

							<img src= "img/events/<?=$event['event_image']?>" width="100px" height="100px">
							<div class="input-group">
								<label>Change Image <input type="file" name="image"  class="form-control" /></label>
							</div>
		
		 				<?php endwhile?>
			</div>
			<div class="panel-footer">
			   <div class="input-group">
				  <input type="submit" name="update" value="Update" class="btn btn-primary form-control" />
				</div>
			</div>
	   </form>	


	   
	</div>
	
	</div>
</div>
				
                <!-- /. ROW  -->

				 <br>
	<div class="row">
		<div class="col-lg-1 col-md-1"></div>
		<div class="col-lg-10 col-md-10">
				<h4> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newArticle">Add Event Speakers</button> </h4>
				<hr>
					<?php 
					 $result_post = $db->query("SELECT * FROM events_speakers WHERE event_id ='$event_id'  ORDER BY speaker_id DESC");
		             ?> 
					 
						<h3>Event Speakers</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead> 
                                <tr>
                                    <th>No</th>
                                    <th>Speaker's Names</th>
                                    <th>Speaker's Position</th>
									<th>Speaker's Image</th>
									<th>Action</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($post = $result_post->fetch_assoc()): ?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$post['speaker_names']?></td>
			                         <td><?=$post['speaker_position']?></td>
                                     <td> <img src="img/event_speaker/<?=$post['speaker_image']?>" alt="" width="50px"></td>
				                 
									 <td><a href="?speaker_id=<?=$post['speaker_id']?>&action=delete&event_id=<?=$event_id?>"class="btn btn-danger">Delete</a></td>
		                         </tr>
							
                            </tbody>
							<?php endwhile?>
                        </table>
			
    </div>
        <!-- page end-->
      </section>
    </section>
</section>
                <!-- /. ROW  -->
	 
	 <?php include_once ('footer.php');?>
    
	 <div id="newArticle" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Speakers For Event</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label> Speaker's Name: <input type='text' name='speaker_names' class='form-control' required /></label>
													</div>
													
													<div class='input-group'>                      
														<label> Speaker's Position: <input type='text' name='speaker_position' class='form-control' required /></label>
													</div>

												
																				
													<div class='input-group'>
														<label> Upload cover Speaker's Image <input type='file' name='image' class='form-control' required /></label>
														<p>Please Note Image size should be below <span style='color:red;'>1MB </span>and Image Dimension is <span style='color:red;'>1024x768px </span> </p>
													</div>
										
								
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='speaker_submit' value='Submit Speaker' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>   