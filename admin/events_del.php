<?php
session_start();
include ('../includes/db_connect.php');
if(!isset($_SESSION['admin_id'])){
	header('Location: login.php');
	exit();	
}  

if(!isset($_GET['event_id'])){
	header('Location: events.php');
	exit();	
}  else{
	$event_id = $_GET['event_id'];
	$delete = $db->query("DELETE FROM `events` WHERE `events`.`event_id` = $event_id");
    if(	$delete){
		header('Location: events.php');
	}
}
?>