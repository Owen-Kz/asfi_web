<?php 
  include_once ('header.php');
  include_once ('side_content.php');
  
  // Handle actual deletion after confirmation
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 1) {
      if (isset($_POST['selected_members']) && !empty($_POST['selected_members'])) {
          $selected_members = $_POST['selected_members'];
          // Sanitize the input to prevent SQL injection
          $selected_members = array_map(function($id) use ($db) {
              return $db->real_escape_string($id);
          }, $selected_members);
          
          $ids = implode("','", $selected_members);
          $delete_query = "DELETE FROM members_registration WHERE member_id IN ('$ids')";
          
          if ($db->query($delete_query)) {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Selected members have been deleted successfully.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
              
              // Refresh the page to update the list
              echo '<script>setTimeout(function(){ window.location.href = window.location.href.split("?")[0]; }, 2000);</script>';
          } else {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  Error deleting members: ' . $db->error . '
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
          }
      }
  }
  
  // Pagination setup
  $records_per_page = 10; // Number of records to show per page
  
  // Get current page from URL, default to 1
  $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
  
  // Calculate the offset for the query
  $offset = ($current_page - 1) * $records_per_page;
  
  // Get total number of members
  $result_total = $db->query("SELECT COUNT(*) as total FROM members_registration");
  $total_records = $result_total->fetch_assoc()['total'];
  $total_pages = ceil($total_records / $records_per_page);
  
  // Ensure current page is within valid range
  if ($current_page > $total_pages) {
      $current_page = $total_pages;
  }
  if ($current_page < 1) {
      $current_page = 1;
  }
  
  // Fetch members for the current page
  $result_users = $db->query("SELECT * FROM members_registration LIMIT $records_per_page OFFSET $offset");
  $count = $offset; // Start count from the offset
?>

    <!--main content start-->
    <section id="main-content">
	 <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Registered Members</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-square-o"></i>Registered Members</li>
            </ol>
          </div>
        </div>
         	<div class="box-header with-border">
              <div class="row">
                  <div class="col-md-12">
                      <div class="pull-right">
                        <a class="btn btn-success" href="export.php"><i class="icon_plus_alt2"></i> Export To Xcel</a>
                        <button type="button" class="btn btn-danger" id="deleteSelected" disabled>
                            <i class="icon_trash"></i> Delete Selected
                        </button>                                          
                      </div>
                  </div>
              </div>
          </div><!-- /.box-header -->
          <br>
        <!-- page start-->
        <form method="post" id="deleteForm">
          <input type="hidden" name="confirm_delete" value="1">
         <div class="row">
          <div class="col-lg-12">
                
            <section class="panel">
              <header class="panel-heading">
              <?=$total_records;?> Registered Members (Showing <?=($offset+1)." - ".min($offset + $records_per_page, $total_records)?>)
              </header>

              <table class="table table-striped table-advance table-hover">
                
				<tbody>
                  <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th> S/N</th> 
                    <th><i class="icon_profile"></i> First Name</th>
                    <th><i class="icon_profile"></i> Surname</th>
                    <th><i class="icon_mail"></i> Email</th>
                    <th><i class="fa fa-user"></i> Gender</th>
                    <th><i class="icon_mobile"></i> Country Of Origin</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
         <?php while($user = $result_users->fetch_assoc()): ?>
				  <tr>
				    <td><input type="checkbox" class="memberCheckbox" name="selected_members[]" value="<?=$user['member_id']?>"></td>
				    <td><?php echo ++$count ?></td>
                    <td><?=$user['member_firstname']?> </td>
                    <td><?=$user['member_surname']?></td>
                    <td><?=$user['member_email']?></td>
                    <td><?=$user['member_gender']?></td>
                    <td><?=$user['member_country']?></td>
                    <td><div class="btn-group">
                        <a class="btn btn-primary" href="member_details.php?member_id=<?=$user['member_id']?>"><i class="icon_plus_alt2"></i> View Details</a>
                        </div>
                    </td>
                </tr>
				<?php endwhile?>
                </tbody>
              </table>
              
              <!-- Pagination Controls -->
              <div class="text-center">
                  <ul class="pagination">
                      <?php if ($current_page > 1): ?>
                          <li><a href="?page=<?= $current_page - 1 ?>">Previous</a></li>
                      <?php else: ?>
                          <li class="disabled"><span>Previous</span></li>
                      <?php endif; ?>
                      
                      <?php
                      // Show page numbers
                      $start_page = max(1, $current_page - 2);
                      $end_page = min($total_pages, $start_page + 4);
                      
                      // Adjust if we're near the beginning
                      if ($end_page - $start_page < 4 && $start_page > 1) {
                          $start_page = max(1, $end_page - 4);
                      }
                      
                      for ($i = $start_page; $i <= $end_page; $i++): 
                      ?>
                          <li class="<?= $i == $current_page ? 'active' : '' ?>">
                              <a href="?page=<?= $i ?>"><?= $i ?></a>
                          </li>
                      <?php endfor; ?>
                      
                      <?php if ($current_page < $total_pages): ?>
                          <li><a href="?page=<?= $current_page + 1 ?>">Next</a></li>
                      <?php else: ?>
                          <li class="disabled"><span>Next</span></li>
                      <?php endif; ?>
                  </ul>
              </div>
              
            </section>
          </div>
        </div>
        </form>
        <!-- page end-->
        <!-- page end-->
      </section>
      
      <!-- Confirmation Modal -->
      <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Are you sure you want to delete the selected members? This action cannot be undone.
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                  </div>
              </div>
          </div>
      </div>
      
      <script>
      $(document).ready(function() {
          // Select all functionality
          $('#selectAll').click(function() {
              $('.memberCheckbox').prop('checked', this.checked);
              updateDeleteButton();
          });
          
          // Update delete button state based on selection
          $('.memberCheckbox').change(function() {
              // If all checkboxes are checked, check the "Select All" checkbox
              var allChecked = $('.memberCheckbox:checked').length === $('.memberCheckbox').length;
              $('#selectAll').prop('checked', allChecked);
              
              updateDeleteButton();
          });
          
          function updateDeleteButton() {
              var anyChecked = $('.memberCheckbox:checked').length > 0;
              $('#deleteSelected').prop('disabled', !anyChecked);
          }
          
          // Delete selected members - show modal instead of browser confirm
          $('#deleteSelected').click(function() {
              $('#confirmationModal').modal('show');
          });
          
          // Handle the actual deletion when confirm button is clicked
          $('#confirmDelete').click(function() {
              $('#deleteForm').submit();
          });
      });
      </script>
      
   <?php include_once ('footer.php');?>