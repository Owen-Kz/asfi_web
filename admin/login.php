<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
 $result ="";
   if(isset($_POST['submit'])){
	   $user = $_POST['username']; 
	   $pwrd = $_POST['pwrd'];
	   //include database connection
	   include ('../includes/db_connect.php');
	   if(empty($user) || empty($pwrd)){
		   $result = "Username and Password is empty"; 
	   } else{
		   $user = strip_tags($user);
		   $user = $db->real_escape_string($user);
		   $pwrd = strip_tags($pwrd);
		   $pwrd = $db->real_escape_string($pwrd);
		   $pwrd = md5($pwrd);
		   
		   $query = $db->query("SELECT admin_id, admin_username FROM admin WHERE admin_username='$user' AND admin_password='$pwrd'");
		   if($query->num_rows ===1){
			   while($row =$query->fetch_object()){
				$_SESSION['admin_username']= $row->admin_username;
				$_SESSION['admin_id'] = $row->admin_id;
			   }
			   header('Location: index.php');
			   exit();
		   }else{
			  $result = "Username and Password incorrect"; 
		   }
	   }
   }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keyword" content="">
  <link rel="shortcut icon" href="img/favicon.png">

  <title>Admin Login | African Science Frontiers Initiatives (ASFI)</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
</head>

<body class="login-img3-body">

  <div class="container">

    <form class="login-form"  action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
         <p><?=$result;?></p>
        
        </div>
		 <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" name="pwrd"  placeholder="Password">
        </div>
        <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Login</button>
      </div>
    </form>
    <div class="text-right">
      <div class="credits">
        
          Designed by <a href="#">WebHub Services</a>
        </div>
    </div>
  </div>


</body>

</html>
