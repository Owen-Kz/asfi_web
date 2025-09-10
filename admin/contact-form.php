<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

// Pagination configuration
$results_per_page = 15; // Number of results per page

// Get current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate offset
$offset = ($page - 1) * $results_per_page;

// Get total number of contacts
$total_result = $db->query("SELECT COUNT(*) as total FROM contact");
$total_row = $total_result->fetch_assoc();
$total_contacts = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_contacts / $results_per_page);

// Ensure page doesn't exceed total pages
if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
}

// Fetch contacts for current page with optimized query
$result_contact = $db->query("SELECT contact_id, contact_name, contact_email, contact_message FROM contact ORDER BY contact_id DESC LIMIT $offset, $results_per_page");

if(isset($_GET['action'])){

	if($_GET['action'] == 'delete'){
		
		$contact_id = (int)$_GET['contact_id'];

		$delete = $db->query("DELETE FROM `contact` WHERE `contact`.`contact_id` = $contact_id");
	
		if($delete){
			$_SESSION['alert'] = "Contact deleted successfully";
			$_SESSION['alert_code'] = "success";
			$_SESSION['alert_link'] = "contact-form.php?page=" . $page; // Preserve current page
			
			// Redirect to avoid resubmission on refresh
			header("Location: contact-form.php?page=" . $page);
			exit();
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
                <p>Total: <?= $total_contacts ?> contact submissions</p>
            </div>
        </div>
	
		<div class="row">
		    <div class="col-lg-1 col-md-1"></div>
			<div class="col-lg-10 col-md-10">
					 
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
                    <tbody>
                    <?php
                    $count = ($page - 1) * $results_per_page + 1;
                    if ($result_contact->num_rows > 0) {
                        while($contact = $result_contact->fetch_assoc()): 
                    ?>
                        <tr>
                            <td><?=$count++?></td>
                            <td><?=htmlspecialchars($contact['contact_name'])?></td>
                            <td><?=htmlspecialchars($contact['contact_email'])?></td>
							<td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;" title="<?=htmlspecialchars($contact['contact_message'])?>">
                                <?=strlen($contact['contact_message']) > 100 ? substr(htmlspecialchars($contact['contact_message']), 0, 100) . '...' : htmlspecialchars($contact['contact_message'])?>
                            </td>
							<td> 
                                <a href="?contact_id=<?=$contact['contact_id']?>&action=delete&page=<?=$page?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
                            </td>
		                </tr>
					<?php 
                        endwhile;
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No contact submissions found</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="text-center">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li><a href="?page=1">&laquo; First</a></li>
                            <li><a href="?page=<?= $page - 1 ?>">Previous</a></li>
                        <?php endif; ?>
                        
                        <?php
                        // Show page numbers with ellipsis for many pages
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        if ($start_page > 1) {
                            echo '<li><a href="?page=1">1</a></li>';
                            if ($start_page > 2) echo '<li class="disabled"><span>...</span></li>';
                        }
                        
                        for ($i = $start_page; $i <= $end_page; $i++):
                        ?>
                            <li class="<?= $i == $page ? 'active' : '' ?>">
                                <a href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                      <?php  if ($end_page < $total_pages) {
                            if ($end_page < $total_pages - 1){
						    echo '<li class="disabled"><span>...</span></li>';
                            echo '<li><a href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
							}
                        }
                        ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <li><a href="?page=<?= $page + 1 ?>">Next</a></li>
                            <li><a href="?page=<?= $total_pages ?>">Last &raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                    
                    <p>Page <?= $page ?> of <?= $total_pages ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- /. ROW  -->
        <!-- page end-->
      </section>
    </section>
</section>		   
		 
<?php include_once ('footer.php');?>