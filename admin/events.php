<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');


if(isset($_POST['event_add'])){
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

	
	if(empty($event_title) || empty($event_details)){
		$result = "<p style='color:red;'> Please Fill all Field  </p>";
	}else{
		$query = $db->query("INSERT INTO events (event_title, event_date, event_time, event_location, event_link, event_details, event_status, event_image) 
		                                 VALUES('$event_title', '$event_date', '$event_time', '$event_location', '$event_link', '$event_details', ' ', '$image')");
		// move image
		if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
			echo "<script>alert('Successful added'); </script>";
		}else{
			echo "<script>alert('Unsuccessful Try again'); </script>";
		}
	}
	
}
?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Upcoming Event</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Upcoming Event</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>Upcoming Event</h2>
                    </div>
     </div>
	<div class="row">
	      <div class="col-md-12">
                        <h4>Add New Upcoming Event <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newArticle">Click Here</button> </h4>
					</div>                       
    </div>
				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_event = $db->query("SELECT * FROM events ORDER BY event_id DESC");
		             ?> 
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Event title</th>
                                    <th>Date and Time</th>
									<th>Event Location</th>
									<th>Registered For Event</th>
									<th>Action</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($event = $result_event->fetch_assoc()): 
								$event_id = $event['event_id'];
								$result_event_reg = $db->query("SELECT * FROM events_registration WHERE event_id = $event_id ");
							?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$event['event_title']?></td>
			                         <td><?=$event['event_date']?> <?=$event['event_time']?></td>
                                    <td> <?=$event['event_location']?></td>
									<td><a href="events_reg.php?event_id=<?=$event['event_id']?>"><?php echo $result_event_reg ->num_rows ?></a> </td>
				                 
									 <td><a href="events_edit.php?event_id=<?=$event['event_id']?>"class="btn btn-primary">Event Details</a> <a href="events_del.php?event_id=<?=$event['event_id']?>"class="btn btn-danger">Delete</a></td>
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
						<h4 class="modal-title">Add Upcoming Events</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label>Events Title: <input type='text' name='event_title' class='form-control' required /></label>
													</div>
													
													<div class='input-group'>                      
														<label> Event Date: <input type='date' name='event_date' class='form-control' required /></label>
													</div>
													<div class='input-group'>                      
														<label> Event Time: <input type='time' name='event_time' class='form-control' required /></label>
													</div>
													<div class='input-group'>                      
														<label> Event Location: <input type='text' name='event_location' class='form-control' required /></label>
													</div>
														<label> Event Link: <input type='text' name='event_link' class='form-control' required /></label>
													</div>
												
													
													<div class="input-group">
                        								<label> Event Details <textarea class="form-control "  name="event_details"></textarea></label>
                        																			<script>
                        																					CKEDITOR.replace('event_details');
                        																			</script>
                        							</div>
									
													<div class='input-group'>
														<label> Upload cover image for Event <input type='file' name='image' class='form-control' required /></label>
														<p>Please Note Image size should be below <span style='color:red;'>1MB </span>and Image Dimension is <span style='color:red;'>1024x768px </span> </p>
													</div>
										
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='event_add' value='Add' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>  