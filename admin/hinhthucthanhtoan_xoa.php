<?php
	include("../user/connect.php");
	$id = $_GET['id'];
	$sql =  "DELETE FROM hinhthucthanhtoan WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$query = $stmt->execute();
	if($query){
		header("location:hinhthucthanhtoan.php");
	}
?>