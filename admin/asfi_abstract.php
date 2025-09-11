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

// Get total number of abstracts
$total_result = $db->query("SELECT COUNT(*) as total FROM abstract");
$total_row = $total_result->fetch_assoc();
$total_abstracts = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_abstracts / $results_per_page);

// Ensure page doesn't exceed total pages
if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
}

// Fetch abstracts for current page
$result_event = $db->query("SELECT * FROM abstract ORDER BY abstract_id DESC LIMIT $offset, $results_per_page");
?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>ASFI Submitted Abstract</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>ASFI Submitted Abstract</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>ASFI Submitted Abstract</h2>
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
                                    <th>Abstract's Author</th>
                                    <th>Abstract's Title</th>
									<th>Presentation Type</th>
                                    <th>Submitted Date</th>
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
		                             <td><?=$event['presenter']?></td>
			                         <td><?=$event['title']?></td>
									 <td><?=$event['presentation_type']?></td>
                                     <td><?=$event['date']?></td>
									 <td> <a href="abstract_page.php?abstract_id=<?=$event['abstract_id']?>"class="btn btn-danger">See Abstract</a></td>
		                         </tr>
							
                            </tbody>
							<?php endwhile;
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No abstracts found</td></tr>';
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
                            
                            <p>Page <?= $page ?> of <?= $total_pages ?> (Total: <?= $total_abstracts ?> abstracts)</p>
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