<?php 
  include_once ('header.php');
 include_once ('side_content.php');
 $count = 0;

?>




    <!--main content start-->
    <section id="main-content">
	 <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Registered Users</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-square-o"></i>Registered Users</li>
            </ol>
          </div>
        </div>
        <?php 
					 $result_users = $db->query("SELECT * FROM user_table");
				
		     ?>	
        <!-- page start-->
         <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
              <?=$result_users->num_rows;?> Registered Users
              </header>

            
              <table class="table table-striped table-advance table-hover">
                
				<tbody>
                  <tr>

                    <th> S/N</th> 
                    <th><i class="icon_profile"></i> Full Name</th>
                    <th><i class="icon_mail"></i> Email</th>
                    <th><i class="icon_mobile"></i> Phone Number</th>
                    <th><i class="fa fa-user"></i> Gender</th>
                    <th><i class="icon_cogs"></i> Action</th>
                  </tr>
         <?php while($user = $result_users->fetch_assoc()): ?>
				  <tr>
				    <td><?php echo ++$count ?></td>
            <td><?=$user['first_name']?> <?=$user['last_name']?></td>
					  <td><?=$user['email']?></td>
            <td><?=$user['phone_number']?></td>
            <td><?=$user['gender']?></td>
            <td><div class="btn-group">
                <a class="btn btn-primary" href="user_details.php?user_id=<?=$user['user_id']?>"><i class="icon_plus_alt2"></i> View Details</a>
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
