<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Website Visitors</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Website Visitors</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>Website Visitors</h2>
                    </div>
     </div>

				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_testimony = $db->query("SELECT * FROM visitors ORDER BY visitors_id DESC");
		             ?> 
					 
						<h3>Content Table</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Visitors</th>
                                  
                                </tr>
                            </thead>
                            <?php
                             $count =1;
							while($testimony = $result_testimony->fetch_assoc()): ?>
							<tbody>      
                                 <tr>
								     <td><?=$count++?></td>
		                             <td><h3><?=$testimony['visitor_date']?></h3></td>
			                         <td><h3><?=$testimony['visitor_count']?></h3></td>
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
				