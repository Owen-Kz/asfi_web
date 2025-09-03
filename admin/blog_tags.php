<?php

 include('header.php');
include ('../includes/db_connect.php');
$result="";

if(isset($_POST['tags_sumbit'])){

	$tag_name = $_POST['tag_name'];
	$tag_name = strip_tags($tag_name);
	$tag_name = $db->real_escape_string($tag_name);

	
	if(!empty($tag_name)){
		$query = $db->query("INSERT INTO  post_categories (post_cat_name) VALUES('$tag_name')");
		
		if($query){
			echo "<script> alert('Added Successfully');</script>";
			}else{
				echo "<script> alert('Not Successfully');</script>";
			}
		}
	}
	

  include('side_content.php');
 ?>

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Blog Category</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-home"></i><a href="post.php">Blog</a></li>
              <li><i class="fa fa-bars"></i>Blog Category</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
     
	 	 <div class="row">
                    <div class="col-md-12">
                        <h2>Blog Category</h2>
                    </div>
     </div>
	 <div class="row">
	      <div class="col-md-12">
                        <h4>Add New Category <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new">Click Here</button> </h4>
                    </div>          
                       
    </div>
	
				 <br>
		<div class="row">
		<div class="col-lg-2 col-md-2"></div>
					<div class="col-lg-8 col-md-8">
		            <?php 
					 $count = 0;
					 $result_row = $db->query("SELECT * FROM post_categories");
		             ?>  
					   <h3>All Blog Categories</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Category </th>
									<th>Number of blog</th>
                                </tr>
                            </thead>
							<?php while($cate = $result_row->fetch_assoc()): ?>
							<tbody>
							  <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?=$cate['post_cat_name']?></td>
							
									<td><a href=""><?php 
									 $cat_count = $cate['post_cat_name'];
									 $result_count = $db->query("SELECT * FROM posts WHERE category = '$cat_count'");
									 echo $result_count->num_rows;
									 ?></a>
									 </td>
							  </tr>
                             
                            </tbody>
							<?php endwhile?>
                        </table>
					 
					 
					 
					 </div>
        </div>
        
					
				
                <!-- /. ROW  -->
		
        <!-- page end-->
      </section>
    </section>
    <?php
 
 include('footer.php');
 ?>
 
 <div id="new" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New </h4>
      </div>
      <div class="modal-body">
              <div class="panel panel-primary">
                           
                            <div class="panel-body">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                       

                        <div class="input-group">
                              <label> Tag Name  <input type="text" name="tag_name" class="form-control" /> </label>
                        </div>
						 
						 <div class="input-group">
                             <p> <?=$result?></p> 
                         </div>
						 <div class="panel-footer">
                               <div class="input-group">
                                  <input type="submit" name="tags_sumbit" value="Add Tag" class="btn btn-primary form-control" />
                                </div>
                            </div>
                       </form>	 
					
                     </div>
    </div>
                     
   </div>
</div>
