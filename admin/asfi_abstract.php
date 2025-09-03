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
            <h3 class="page-header"><i class="fa fa fa-bars"></i>ASFI Sudmitted Abstract</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>ASFI Sudmitted Abstract</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
		 <div class="row">
                    <div class="col-md-12">
                        <h2>ASFI Sudmitted Abstract</h2>
                    </div>
     </div>
	
				 <br>
		<div class="row">
		<div class="col-lg-1 col-md-1"></div>
					<div class="col-lg-10 col-md-10">
					<?php 
					 $result_event = $db->query("SELECT * FROM abstract ORDER BY abstract_id DESC");
		             ?> 
					 
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
                             $count =1;
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

	