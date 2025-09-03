<?php
include('header.php');
include ('../includes/db_connect.php');
$result="";

if(isset($_POST['tags_sumbit'])){

	$tag_name = $_POST['tag_name'];
	$tag_name = strip_tags($tag_name);
	$tag_name = $db->real_escape_string($tag_name);

	
	if(!empty($tag_name)){
		$query = $db->query("INSERT INTO categories (category_name) VALUES('$tag_name')");
		
		if($query){
			echo "<script> alert('Added Successfully');</script>";
			}else{
				echo "<script> alert('Not Successfully');</script>";
			}
		}
	}

	
  if(isset($_POST['category_edit'])){

    $hidden_category_id = $_POST['hidden_category_id'];
    $hidden_category_id = strip_tags($hidden_category_id);
    $hidden_category_id = $db->real_escape_string($hidden_category_id);

    $category_name = $_POST['category_name'];
    $category_name = strip_tags($category_name);
    $category_name = $db->real_escape_string($category_name);
  
   
    if(empty($category_name)){
  
      $_SESSION['alert'] = "Please Fill all Field ";
      $_SESSION['alert_code'] = "error";
      $_SESSION['alert_link'] = "tags.php";
  
    }else{
      $query = $db->query("UPDATE `categories` SET `category_name` = '$category_name' WHERE `categories`.`category_id` = $hidden_category_id");
      if($query){
        $_SESSION['alert'] = "Category Edited Successfully";
        $_SESSION['alert_code'] = "success";
        $_SESSION['alert_link'] = "tags.php";
      }else{
        $_SESSION['alert'] = "Not Edited Please try again ";
        $_SESSION['alert_code'] = "error";
        $_SESSION['alert_link'] = "tags.php";
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
            <h3 class="page-header"><i class="fa fa fa-bars"></i>Category</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><a href="products.php">Products</a></li>
              <li><i class="fa fa-bars"></i>Products Category</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
     
	 	 <div class="row">
                    <div class="col-md-12">
                        <h2>Product Category</h2>
                    </div>
     </div>
	 <div class="row">
	      <div class="col-md-12">
          <h4>Add New Category <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new">New Category</button> </h4>
        </div> 
  
                       
    </div>
	
				 <br>
		<div class="row">
		<div class="col-lg-2 col-md-2"></div>
					<div class="col-lg-8 col-md-8">
		            <?php 
					 $count = 0;
					 $result_row = $db->query("SELECT * FROM categories");
		             ?>  
					   <h3>All Categories</h3>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Category </th>
                                    
									                  <th>Number of Sub Category</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
							<?php while($cate = $result_row->fetch_assoc()): ?>
							<tbody>
							  <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?=$cate['category_name']?></td>
							
									<td><a href=""><?php 
									 $id_count = $cate['category_id'];
									 $result_count = $db->query("SELECT * FROM product_sub_category WHERE category = '$id_count'");
									 echo $result_count->num_rows;
									 ?></a>
									 </td>
                   <td><a class="btn btn-primary view" href="#myModalServiceEdit" data-toggle="modal" name="<?php echo $cate['category_id']?>"> Edit</a>  <a href="sub_category.php?category_id=<?php echo $cate['category_id']?>" class="btn btn-danger">View Sub-Category</a></td>
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
 
 

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModalServiceEdit" class="modal fade">
        <div class="modal-dialog">
             <div class="modal-content">
                <div class="modal-body" id="detail_category">
                </div>
            </div>
        </div>
    </div>



    <div id="new" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Category</h4>
      </div>
      <div class="modal-body">
              <div class="panel panel-primary">
                           
                            <div class="panel-body">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                       

                        <div class="input-group">
                              <label> Category Name  <input type="text" name="tag_name" class="form-control" /> </label>
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

<script>
  $(document).ready(function(){
	  $('.view').click(function(){
      var category_id = $(this).attr("name");
		  $.ajax({
			  url:"select_category.php",
			  method:"post",
			  data:{category_id:category_id},
			  success:function(data){
				  $('#detail_category').html(data);
				 
			  }
		  }); 
		  
	  });
  });  
</script>