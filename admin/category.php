<?php
session_start();
include ('../includes/db_connect.php');
if(!isset($_SESSION['admin_id'])){
	header('Location: login.php');
	exit();	
}
$result="";

if(isset($_POST['sumbit'])){
	

	$category_name = $_POST['category_name'];
	$category_name = strip_tags($category_name);
	$category_name = $db->real_escape_string($category_name);
	
	
	
	if(empty($category_name)){
		$result = "<p style='color:red;'> Please Fill all Field  </p>";
	}else{
		$query = $db->query("INSERT INTO categories (category_name) VALUES('$category_name')");
		
		if($query){
			$result = "<p style='color:green;'> Category added successfully  </p>";
		}else{
			$result = "<p style='color:red;'> Category not added try again  </p>";
		}
	}
	
}
?>

<?php include_once ('header.php');?>
     
	 	 <div class="row">
                    <div class="col-md-12">
                        <h2>CATEGORIES</h2>
                    </div>
     </div>
	<div class="row">
                    <div class="col-lg-4 col-md-4">
                  
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Add New Category
                            </div>
                            <div class="panel-body">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                       

                        <div class="input-group">
                              <label> Category Name  <input type="text" name="category_name" class="form-control" /> </label>
                        </div>
						
                         </div>
						 
						 
						 
						 <div class="input-group">
                             <p><?=$result?></p> 
                         </div>
						 
					
                            </div>
                            <div class="panel-footer">
                               <div class="input-group">
                                  <input type="submit" name="sumbit" value="Add" class="btn btn-primary form-control" />
                                </div>
                            </div>
                       </form>	 
                    </div>

                       
                 </div>
					<div class="col-lg-8 col-md-8">
		            <?php 
					 $count = 0;
					 $result_row = $db->query("SELECT * FROM Categories");
		             ?> 
			    
					   <h3>All Category</h3>
					  
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Category Name</th>
									<th>Number of Books</th>
   
                                </tr>
                            </thead>
                            
							<?php while($cat = $result_row->fetch_assoc()): ?>
							<tbody>
							  <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?=$cat['category_name']?></td>
							
									<td></td>
							  </tr>
                             
                            </tbody>
							<?php endwhile?>
                        </table>
					 
					 
					 
					 </div>
                    </div>
        
					
				
                <!-- /. ROW  -->
	 
	 <?php include_once ('footer.php');?>
    