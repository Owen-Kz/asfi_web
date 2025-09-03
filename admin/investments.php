<?php 
  include_once ('header.php');
 include_once ('side_content.php');
?>




    <!--main content start-->
    <section id="main-content">
	 <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Crop Investment</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Crop Investment</li>
            </ol>
          </div>
        </div>
		
		 <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><a href="invest.php?action=new">
            <div class="info-box red-bg">
             
              <div class="count"><?php 
                $result_row = $db->query("SELECT * FROM investment WHERE invest_status = ' ' ");
                  echo $result_row->num_rows;
		             ?></div>
              <div class="title">New Investment</div>
            </div></a>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><a href="invest.php?action=Closed">
            <div class="info-box purple-bg">
            
              <div class="count"><?php 
					 $result_row = $db->query("SELECT * FROM investment WHERE invest_status = 'Closed' ");
				     echo $result_row->num_rows;
		             ?></div>
              <div class="title">Completed Investment</div>
            </div></a>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><a href="invest.php?action=Active">
            <div class="info-box green-bg">
          
              <div class="count"><?php 
                  $result_row = $db->query("SELECT * FROM investment WHERE invest_status = 'Active' ");
                    echo $result_row->num_rows;
		             ?></div>
              <div class="title">Active Investment</div>
            </div></a>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><a href="invest.php?action=All business">
            <div class="info-box dark-bg">
              <i class="fa fa-cubes"></i>
              <div class="count"><?php 
                  $result_row = $db->query("SELECT * FROM investment");
                    echo $result_row->num_rows;
		             ?></div>
              <div class="title">All Investment</div>
            </div></a>
            <!--/.info-box-->
          </div>
          <!--/.col-->
        </div>
	
   
        <!-- page end-->
        <!-- page end-->
      </section>
   <?php include_once ('footer.php');?>
