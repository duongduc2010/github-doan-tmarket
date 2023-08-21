<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql =  "DELETE FROM timezone WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	if($query){
		header("location:timezone.php");
	}
?>