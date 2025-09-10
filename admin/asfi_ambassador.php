<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

// Pagination configuration
$results_per_page = 10; // Number of results per page

// Get current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate offset
$offset = ($page - 1) * $results_per_page;

// Get total number of ambassadors
$total_result = $db->query("SELECT COUNT(*) as total FROM asfi_ambassador");
$total_row = $total_result->fetch_assoc();
$total_ambassadors = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_ambassadors / $results_per_page);

// Ensure page doesn't exceed total pages
if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
}

// Fetch ambassadors for current page
$result_event = $db->query("SELECT * FROM asfi_ambassador ORDER BY asfi_ambassador_id DESC LIMIT $offset, $results_per_page");

if(isset($_POST['amb_submit'])){
	//location of file
	$target = "img/ambassador/".basename($_FILES['image']['name']);
	// get data from form
	$image = $_FILES['image']['name'];

	$asfi_ambassador_names = $_POST['asfi_ambassador_names'];
	$asfi_ambassador_names = strip_tags($asfi_ambassador_names);
	$asfi_ambassador_names = $db->real_escape_string($asfi_ambassador_names);
	
	
	$asfi_ambassador_country = $_POST['asfi_ambassador_country'];
	$asfi_ambassador_country = strip_tags($asfi_ambassador_country);
	$asfi_ambassador_country = $db->real_escape_string($asfi_ambassador_country);
	
	$asfi_ambassador_position = $_POST['asfi_ambassador_position'];
	$asfi_ambassador_position = strip_tags($asfi_ambassador_position);
	$asfi_ambassador_position = $db->real_escape_string($asfi_ambassador_position);

	$asfi_ambassador_year = $_POST['asfi_ambassador_year'];
	$asfi_ambassador_year = strip_tags($asfi_ambassador_year);
	$asfi_ambassador_year = $db->real_escape_string($asfi_ambassador_year);

	
	if(empty($asfi_ambassador_names) || empty($asfi_ambassador_country)){
		$result = "<p style='color:red;'> Please Fill all Field  </p>";
	}else{
		$query = $db->query("INSERT INTO asfi_ambassador (asfi_ambassador_names, asfi_ambassador_country, asfi_ambassador_position, asfi_ambassador_image, asfi_ambassador_year) 
		                                 VALUES('$asfi_ambassador_names', '$asfi_ambassador_country', '$asfi_ambassador_position', '$image', '$asfi_ambassador_year')");
		// move image
		if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
			$_SESSION['alert'] = "Ambassador added successfully";
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
			
			$asfi_ambassador_id = $_GET['asfi_ambassador_id'];

			$delete = $db->query("DELETE FROM `asfi_ambassador` WHERE `asfi_ambassador`.`asfi_ambassador_id` = $asfi_ambassador_id");
		
			if($delete){

				$_SESSION['alert'] = "Ambassador Removed";
				$_SESSION['alert_code'] = "success";
				$_SESSION['alert_link'] = "asfi_ambassador.php";
			}
		}		
	}
?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>ASFI Ambassador</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>ASFI Ambassador</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>ASFI Ambassador</h2>
                    </div>
     </div>
	<div class="row">
	      <div class="col-md-12">
                        <h4>Add New ASFI Ambassador <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newArticle">Click Here</button> </h4>
					</div>                       
    </div>
				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/n</th>
                                    <th>Names</th>
                                    <th>Country</th>
									<th>Position</th>
									<th>Year</th>
									<th>Image</th>
									<th>Action</th>
                                  
                                </tr>
                            </thead>
                            <?php
                            $count = ($page - 1) * $results_per_page + 1;
							if ($result_event->num_rows > 0) {
                                while($event = $result_event->fetch_assoc()): 
							?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><?=$event['asfi_ambassador_names']?></td>
			                         <td><?=$event['asfi_ambassador_country']?></td>
									 <td><?=$event['asfi_ambassador_position']?></td>
									 <td><?=$event['asfi_ambassador_year']?></td>
                                     <td> <img src="img/ambassador/<?=$event['asfi_ambassador_image']?>" width="50px" alt=""> </td>
									 <td> <a href="?asfi_ambassador_id=<?=$event['asfi_ambassador_id']?>&action=delete&page=<?=$page?>"class="btn btn-danger">Remove Ambassador</a></td>
		                         </tr>
							
                            </tbody>
							<?php endwhile;
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No ambassadors found</td></tr>';
                            }
                            ?>
                        </table>
                        
                        <!-- Pagination -->
                        <div class="text-center">
                            <ul class="pagination">
                                <?php if ($page > 1): ?>
                                    <li><a href="?page=1">&laquo; First</a></li>
                                    <li><a href="?page=<?= $page - 1 ?>">Previous</a></li>
                                <?php endif; ?>
                                
                                <?php
                                // Show page numbers
                                $start_page = max(1, $page - 2);
                                $end_page = min($total_pages, $page + 2);
                                
                                for ($i = $start_page; $i <= $end_page; $i++):
                                ?>
                                    <li class="<?= $i == $page ? 'active' : '' ?>">
                                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <li><a href="?page=<?= $page + 1 ?>">Next</a></li>
                                    <li><a href="?page=<?= $total_pages ?>">Last &raquo;</a></li>
                                <?php endif; ?>
                            </ul>
                            
                            <p>Page <?= $page ?> of <?= $total_pages ?> (Total: <?= $total_ambassadors ?> ambassadors)</p>
                        </div>
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
						<h4 class="modal-title">Add ASFI Ambassadors</h4>
					</div>
					<div class="modal-body">
					
								<div class=' panel-primary' style='padding:10px;'>
											<form action='' method='post' enctype='multipart/form-data'>
												<div class='panel-body'>  
													<div class='input-group'>                      
														<label>ASFI Ambassador Names: <input type='text' name='asfi_ambassador_names' class='form-control' required /></label>
													</div>
													
												
													<div class='input-group'>                      
														<label> ASFI Ambassador Country: <input type='text' name='asfi_ambassador_country' class='form-control' required /></label>
													</div>

													<div class='input-group'>                      
														<label> ASFI Ambassador Position: <input type='text' name='asfi_ambassador_position' class='form-control' required /></label>
													</div>
													
													<div class='input-group'>                      
														<label> ASFI Ambassador Year: <input type='text' name='asfi_ambassador_year' class='form-control' required /></label>
													</div>
									
													<div class='input-group'>
														<label> Upload cover image for ASFI Ambassador <input type='file' name='image' class='form-control' required /></label>
														<p>Please Note Image size should be below <span style='color:red;'>1MB </span>and Image Dimension is <span style='color:red;'>1024x768px </span> </p>
													</div>
										
												</div>
												<div class='panel-footer'>
													<div class='input-group'>
														<input type='submit' name='amb_submit' value='Add' class='btn btn-primary form-control' />
													</div>
												</div>
											</form>	 
									</div>
					
					</div>
					</div>

				</div>
			</div>