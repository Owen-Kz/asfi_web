<?php
session_start();
include ('../includes/db_connect.php');
if(!isset($_SESSION['admin_id'])){
	header('Location: login.php');
	exit();	
}  


if(!isset($_GET['pid'])){
	header('Location: post.php');
	exit();	
}  else{
	$pid = $_GET['pid'];
	$delete = $db->query("DELETE FROM `posts` WHERE `posts`.`post_id` = $pid");
    if($delete){
		
		header('Location: post.php');
	}
}
?>