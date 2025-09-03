<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');


if(isset($_GET['action'])){

	if($_GET['action'] == 'delete'){
		
		$contact_id = $_GET['contact_id'];

		$delete = $db->query("DELETE FROM `contact` WHERE `contact`.`contact_id` = $contact_id");
	
		if($delete){

			$_SESSION['alert'] = " Deleted";
			$_SESSION['alert_code'] = "success";
			$_SESSION['alert_link'] = "contact-form.php";
		}
	}		
}

?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Contact Form Data</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Contact Form Data</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>Contact Form Data</h2>
                    </div>
     </div>
	
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_testimony = $db->query("SELECT * FROM contact ORDER BY contact_id DESC");
		             ?> 
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Names</th>
                                    <th>Email</th>
									<th>Comments</th>
									<th>Action</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($testimony = $result_testimony->fetch_assoc()): ?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$testimony['contact_name']?></td>
                                     <td><?=$testimony['contact_email']?></td>
									 <td><?=$testimony['contact_message']?></td>
									 <td> <a href="?contact_id=<?=$testimony['contact_id']?>&action=delete"class="btn btn-danger">Delete</a></td>
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
						<h4 class="modal-full_name">Add Client Testimony</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label> Full Names: <input type='text' name='full_name' class='form-control' required /></label>
													</div>
													<div class='input-group'>
														<label> Comment : <textarea name='comment' class='form-control' cols='80' rows='5' required></textarea> </label>
													</div>
													<div class='input-group'>                      
														<label> Position: <input type='text' name='position' class='form-control' required /></label>
													</div>

													<div class='input-group'>                      
														<label> Image: <input type='file' name='image' class='form-control'  /></label>
													</div>
		
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='testimony_add' value='Add' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>  