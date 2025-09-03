<?php 
  include_once ('header.php');
 include_once ('side_content.php');
 $count = 0;
  if(!isset($_GET['action'])){
	echo "<script> window.location.href='investments.php';</script>";
	exit();
}else{
	$action = $_GET['action'];
}
?>




    <!--main content start-->
    <section id="main-content">
	 <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Investment Lists</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Investment Lists</li>
              <li><i class="fa fa-square-o"></i><?=$action?></li>
            </ol>
          </div>
        </div>
		
		 <?php 
		 if($action == 'new'){
			 $result_order = $db->query("SELECT * FROM investment WHERE invest_status = '' ORDER BY investment_id DESC");
		 }
		 if($action == 'Closed'){
			 $result_order = $db->query("SELECT * FROM investment WHERE invest_status = 'Closed' ORDER BY investment_id DESC");
		 }
		  if($action == 'Active'){
			 $result_order = $db->query("SELECT * FROM investment WHERE invest_status = 'Active' ORDER BY investment_id DESC");
		 }
		  if($action == 'All business'){
			 $result_order = $db->query("SELECT * FROM investment ORDER BY investment_id DESC");
		 }
		 ?> 
        <!-- page start-->
         <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
               <?=$action?>
              </header>

									
              <table class="table table-striped table-advance table-hover">
                
				<tbody>
                <tr>
				            <th>S/N</th>
                    <th>Investor's Name</th>
                    <th>Crop Invested</th>
                    <th>Invested Amount</th>
                    <th>Investment Date</th>
                    <th>Investment Status</th>
                    <th>Action</th>
                </tr>
              <?php while($order = $result_order->fetch_assoc()): ?>
				        <tr>
				            <td><?php echo ++$count ?></td>
                    <td><?=$order['fullname']?></td>
                    <td><?=$order['crop_title']?></td>
					          <td>N<?=number_format($order['amount_invested'], 2)?></td>
                    <td><?=$order['invest_date']?></td>
                    <td>
                      <?php 
                        if($order['invest_status'] = ''){
                          echo"<a href=''class='btn btn-danger'>Not Paid</a>";
                        }else{
                          echo"<a href=''class='btn btn-success'>Paid</a>";
                        }
                      ?>
                    </td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-primary" href="invest_details.php?investment_id=<?=$order['investment_id']?>"> View Details</a>
                      </div>
                    </td>
                </tr>
				      <?php endwhile?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
        <!-- page end-->
      </section>
   <?php include_once ('footer.php');?>
