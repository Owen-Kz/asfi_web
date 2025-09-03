<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');


if(isset($_POST['id_submit'])){


	$member_id = $_POST['member_id'];
	$member_id = strip_tags($member_id);
	$member_id = $db->real_escape_string($member_id);
	
	if(empty($member_id)){
		$result = "<p style='color:red;'> Please Fill all Field  </p>";
	}else{
		$query = $db->query("INSERT INTO `membership_code` (`member_code`) VALUES ('$member_id')");
		// move image
		if($query){
			$_SESSION['alert'] = "Members ID added successfully";
			$_SESSION['alert_code'] = "success";
			$_SESSION['alert_link'] = "";
		}else{
			$_SESSION['alert'] = "Sorry, there was an error uploading your Image";
			$_SESSION['alert_code'] = "error";
			$_SESSION['alert_link'] = "";
		}
	}
	
}
	
	if(isset($_GET['action'])){

		if($_GET['action'] == 'delete'){
			
			$asfi_member_id = $_GET['asfi_member_id'];

			$delete = $db->query("DELETE FROM `membership_code` WHERE `membership_code`.`id` = $asfi_member_id");
		
			if($delete){

				$_SESSION['alert'] = "ID Removed";
				$_SESSION['alert_code'] = "success";
				$_SESSION['alert_link'] = "member_ids.php";
			}
		}		
	}
?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>ASFI Membership ID</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>ASFI Membership ID</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>ASFI Membership ID</h2>
                    </div>
     </div>
	<div class="row">
	      <div class="col-md-12">
                        <h4>Add New ASFI Membership ID <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newArticle">Click Here</button> </h4>
					</div>                       
    </div>
				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_event = $db->query("SELECT * FROM membership_code");
		             ?> 
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/n</th>
                                    <th>Membership ID</th>
									<th>Action</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($event = $result_event->fetch_assoc()): 
							?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$event['member_code']?></td>
									 <td> <a href="?asfi_member_id=<?=$event['id']?>&action=delete"class="btn btn-danger">Remove ID</a></td>
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
						<h4 class="modal-title">Add ASFI Membership ID</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label>ASFI Membership ID: <input type='text' name='member_id' class='form-control' required /></label>
													</div>
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='id_submit' value='Add' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>  