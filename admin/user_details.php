<?php 
  include_once ('header.php');
 include_once ('side_content.php');
 $count = 0;
  if(!isset($_GET['user_id'])){
	echo "<script> window.location.href='users.php';</script>";
	exit();
}else{
  $user_id = $_GET['user_id'];
  $result = $db->query("SELECT * FROM user_table WHERE user_id = $user_id");
     
	  while($reg = $result->fetch_assoc()): 
		$first_name = $reg['first_name'];
		$last_name = $reg['last_name'];
		$email = $reg['email'];
		$phone_number = $reg['phone_number'];
		$gender = $reg['gender'];
		$address = $reg['address'];
		$date = $reg['date'];

    $account_number = $reg['account_number'];
		$account_name = $reg['account_name'];
		$bank = $reg['bank'];
	 endwhile;
}
?>




    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user-md"></i> Profile</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-users"></i><a href="users.php">users</a></li>
              <li><i class="fa fa-user-md"></i><?=$first_name?> <?=$last_name?></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <!-- profile-widget -->
          <div class="col-lg-12">
            <div class="profile-widget profile-widget-info">
            <div class="panel-body ">
                        <h1><?=$first_name?> <?=$last_name?></h1>
                        <div class="row">
                          <div class="bio-row">
                            <h4>Gender : <?=$gender?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Email : <?=$email?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Phone Number : <?=$phone_number?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Date Of Registration : <?=$date?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Address : <?=$address?></h4>
                          </div>
                        </div>
                      </div>
            </div>
          </div>
        </div>




        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading tab-bg-info"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <ul class="nav nav-tabs">
                
                  <li class="active">
                    <a data-toggle="tab" href="#Prescription">
                                          <i class="icon-user"></i>
                                          Bank Details
                                      </a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#Order">
                                          <i class="icon-envelope"></i>
                                          Investment History
                                      </a>
                  </li>
                </ul>
              </header>
              <div class="panel-body">
                <div class="tab-content">
                  <!-- profile -->
                  <div id="Prescription" class="tab-pane active">
                    <h1> Bank Details</h1>
                        <h3>Bank Name: <?=$bank?></h3>
                        <h3>Account Number: <?=$account_number?></h3>
                        <h3>Account Name: <?=$account_name?></h3>
                  </div>
                  <!-- edit-profile -->
                  <div id="Order" class="tab-pane ">
                    <section class="panel">
                      <div class="panel-body bio-graph-info">
                        <h1> Order History</h1>
                       	<?php 
                            $count = 0;
                            $limit = 10;
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($page - 1) * $limit;
                            $end = $start + $limit;
                            $result_order = $db->query("SELECT * FROM investment WHERE user_id=$user_id ORDER BY investment_id DESC LIMIT $start, $limit");
                            $resultCount = $db->query("SELECT * FROM investment WHERE user_id=$user_id");
                            $countAll = $resultCount->num_rows;
                            $pages = ceil( $countAll / $limit );

                            $next = $page + 1;
                            $previous = $page - 1;
                            $adjacents = "2"; 
                            $second_last = $pages - 1; // total page minus 1
                      

                          ?> 
      		
              <table class="table table-striped table-responsive table-hover">
                
				<tbody>
                  <tr>
                    <th> S/N</th>
                    <th> Investment Date</th>
                    <th> Invested Crop</th>
                    <th> Invested Amount</th>
                    <th> Investment Status</th>
                    <th>Action</th>
                  </tr>
                  <?php while($order = $result_order->fetch_assoc()): ?>
				  <tr>
				      <td><?php echo ++$count ?></td>
              <td><?=$order['invest_date']?></td>
              <td><?=$order['crop_title']?></td>
					    <td>N<?=number_format($order['amount_invested'], 2)?></td>
                    <td><?php 
									if($order['invest_status'] =='Not paid'){
							
										echo"<a href='' class='btn btn-danger'>Not Paid</a>";
									}else{
										echo"<a href=''class='btn btn-success'>Paid</a>";
									}	?></td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="order_details.php?order_id=<?=$order['order_id']?>"><i class="icon_plus_alt2"></i> View Details</a>
                      </div>
                    </td>
                  </tr>
				<?php endwhile?>
                </tbody>
			  </table>
                       
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>

        <!-- page end-->
      </section>
    </section> 
      <?php include_once ('footer.php');?>
