<?php 
  include_once ('header.php');
  include_once ('side_content.php');
  
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
                      </div>
                  </div>
              </div>
          </div><!-- /.box-header -->
          <br>
        <!-- page start-->
         <div class="row">
          <div class="col-lg-12">
                
            <section class="panel">
              <header class="panel-heading">
              <?=$total_records;?> Registered Members (Showing <?=($offset+1)." - ".min($offset + $records_per_page, $total_records)?>)
              </header>

              <table class="table table-striped table-advance table-hover">
                
				<tbody>
                  <tr>
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
        <!-- page end-->
        <!-- page end-->
      </section>
   <?php include_once ('footer.php');?>