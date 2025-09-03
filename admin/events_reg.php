<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

if(!isset($_GET['event_id'])){
	header('Location: events.php');
	exit();	
}
	$event_id = $_GET['event_id'];

	
?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Registered For Event</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Registered For Event</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>Registered For Event</h2>
                    </div>
     </div>

				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_event = $db->query("SELECT * FROM events_registration WHERE event_id = $event_id ORDER BY reg_id DESC");
		             ?> 
		              <div class="box-header with-border">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="pull-right">
                                    <a class="btn btn-success" href="export_event_reg.php?event_id=<?=$event_id?>"><i class="icon_plus_alt2"></i> Export To Xcel</a>                                          
                                  </div>
                              </div>
                          </div>
                      </div><!-- /.box-header -->
					 
						<h3><?php echo $result_event ->num_rows ?> Person(s) Are registered for this Event</h3>
                        <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                  <th>S/N</th>
                  <th>Names </th>
									<th>Email</th>
                  <th>Membership</th>
									<th> Country Of Origin</th>
									<th>Reg. Date</th>
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
		                <td><?=$event['firstname']?> <?=$event['lastname']?></td>
			            <td><?=$event['email']?></td>
                        <td> <?=$event['membership']?></td>
                        <td> <?=$event['country_origin']?></td>
                        <td> <?=$event['reg_date']?></td>
						<td><a href="reg_event_details.php?event_reg_id=<?=$event['reg_id']?>"  class="btn btn-primary">View Details</a> </td>
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

	