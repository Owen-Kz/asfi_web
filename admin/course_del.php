<?php
session_start();
include ('../includes/db_connect.php');
if(!isset($_SESSION['admin_id'])){
	header('Location: login.php');
	exit();	
}  

if(!isset($_GET['product_code'])){
	header('Location: products.php');
	exit();	
}  else{
	$product_code = $_GET['product_code'];
	$delete = $db->query("DELETE FROM `products` WHERE `products`.`product_code` = '$product_code'");
    if($delete){
        echo "<script>alert('Product Deleted Successfully'); 
                    window.location.href='products.php';</script>";
	}
}
?>